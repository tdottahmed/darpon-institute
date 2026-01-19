<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateCourseEnrollmentInvoicePdfJob;
use App\Jobs\SendCourseEnrollmentInvoiceJob;
use App\Mail\NewUserPasswordMail;
use App\Models\Course;

use App\Models\CourseRegistration;
use App\Models\LandingPage;
use App\Models\CourseVariation;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CourseRegistrationController extends Controller
{
    /**
     * Show the enrollment form for a specific course.
     */
    public function create(Course $course)
    {
        $paymentGateways = PaymentGateway::active()->get();

        return Inertia::render('Courses/Enroll', [
            'course' => $course->load(['variations' => function ($query) {
                $query->where('status', true)->orderBy('sort_order');
            }]),
            'paymentGateways' => $paymentGateways,
        ]);
    }

    /**
     * Store a newly created registration in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Conditional validation: payment fields required only for paid courses
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_screenshot' => 'nullable|image|max:5120', // 5MB
            'course_variation_id' => 'nullable|exists:course_variations,id',
        ];

        $messages = [
            'email.required' => 'Email address is required. We need this to send your login credentials.',
            'email.email' => 'Please provide a valid email address.',
            'payment_gateway_id.required' => 'Please select a payment method.',
            'transaction_id.required' => 'Please enter your transaction ID.',
            'course_variation_id.exists' => 'Selected variation is invalid.',
        ];

        // Validate variation belongs to course if provided
        $selectedVariation = null;
        if ($request->course_variation_id) {
            $selectedVariation = CourseVariation::where('id', $request->course_variation_id)
                ->where('course_id', $course->id)
                ->where('status', true)
                ->first();
            
            if (!$selectedVariation) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected variation is not available for this course.');
            }
        }

        // Determine price from variation or course for validation
        $totalPrice = $selectedVariation 
            ? ($selectedVariation->discounted_price ?? $selectedVariation->price ?? 0)
            : ($course->discounted_price ?? $course->price ?? 0);

        // Use discounted price so free courses (after discount) are treated as free
        if ($totalPrice > 0) {
            $rules['payment_gateway_id'] = 'required|exists:payment_gateways,id';
            $rules['transaction_id'] = 'required|string|max:255';
        }

        $request->validate($rules, $messages);

        try {
            return DB::transaction(function () use ($request, $course, $selectedVariation, $totalPrice) {
                $user = Auth::user();
                $isNewUser = false;
                $password = null;

                if (!$user) {
                    $user = User::where('email', $request->email)->first();

                    if (!$user) {
                        // Create new user
                        $password = \Illuminate\Support\Str::random(10);
                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($password),
                            'user_type' => 'customer',
                        ]);
                        $isNewUser = true;

                        // Send email (mandatory, failure rolls back transaction)
                        try {
                            Mail::to($user->email)->send(new NewUserPasswordMail($user, $password));
                        } catch (\Exception $mailException) {
                            logger()->error($mailException->getMessage());
                            throw new \Exception('Failed to send email. Please check your email address and try again.');
                        }

                        Auth::login($user);
                    }
                }

                // Determine if course requires payment and handle screenshot upload only for paid courses
                $paymentScreenshot = null;
                $isPaidCourse = $totalPrice > 0;

                if ($isPaidCourse && $request->hasFile('payment_screenshot')) {
                    $paymentScreenshot = $request->file('payment_screenshot')->store('course-registrations/payments', 'public');
                }

                $courseRegistration = CourseRegistration::create([
                    'course_id' => $course->id,
                    'course_variation_id' => $selectedVariation ? $selectedVariation->id : null,
                    'user_id' => $user ? $user->id : null,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'status' => $isPaidCourse ? 'pending' : 'confirmed',
                    'payment_gateway_id' => $isPaidCourse ? $request->payment_gateway_id : null,
                    'transaction_id' => $isPaidCourse ? $request->transaction_id : null,
                    'payment_screenshot' => $paymentScreenshot,
                    'payment_status' => $isPaidCourse ? 'pending' : 'verified',
                    'enrollment_type' => 'online',
                ]);

                // Load relationships for the invoice dialog
                $courseRegistration->load('course', 'courseVariation', 'paymentGateway');

                // Chain jobs: Generate PDF first, then send email
                GenerateCourseEnrollmentInvoicePdfJob::withChain([
                    new SendCourseEnrollmentInvoiceJob($courseRegistration, $totalPrice)
                ])->dispatch($courseRegistration, $totalPrice);

                // Return to enrollment page with registration data to show invoice
                return Inertia::render('Courses/Enroll', [
                    'course' => $course->load(['variations' => function ($query) {
                        $query->where('status', true)->orderBy('sort_order');
                    }]),
                    'paymentGateways' => PaymentGateway::active()->get(),
                    'registration' => $courseRegistration,
                    'totalPrice' => $totalPrice,
                    'isNewUser' => $isNewUser,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit registration. Please try again. ' . $e->getMessage());
        }
    }
    /**
     * Store a newly created registration from a landing page.
     */
    public function storeFromLandingPage(Request $request, $slug)
    {
        $landingPage = LandingPage::where('slug', $slug)
            ->where('status', true)
            ->with(['course.variations'])
            ->firstOrFail();

        $course = $landingPage->course;
        if (!$course) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Course not found for this landing page.');
        }

        // Determine price from landing page or fallback to course
        $offerPrice = $landingPage->pricing_offer_price ?? ($course->discounted_price ?? $course->price ?? 0);
        $totalPrice = $offerPrice;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_screenshot' => 'nullable|image|max:5120', // 5MB
        ];

        // Add payment validation if price > 0
        if ($totalPrice > 0) {
            $rules['payment_gateway_id'] = 'required|exists:payment_gateways,id';
            $rules['transaction_id'] = 'required|string|max:255';
        }

        $request->validate($rules);

        try {
            return DB::transaction(function () use ($request, $course, $totalPrice, $landingPage) {
                // Determine User
                $user = Auth::user();
                $isNewUser = false;
                $password = null;

                if (!$user) {
                    $user = User::where('email', $request->email)->first();

                    if (!$user) {
                        // Create new user
                        $password = \Illuminate\Support\Str::random(10);
                        $user = User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($password),
                            'user_type' => 'customer',
                        ]);
                        $isNewUser = true;

                        // Send email
                        try {
                            Mail::to($user->email)->send(new NewUserPasswordMail($user, $password));
                        } catch (\Exception $mailException) {
                            logger()->error($mailException->getMessage());
                            // Continue without failing transaction for email
                        }

                        Auth::login($user);
                    }
                }

                // Handle Screenshot
                $paymentScreenshot = null;
                $isPaidCourse = $totalPrice > 0;
                if ($isPaidCourse && $request->hasFile('payment_screenshot')) {
                    $paymentScreenshot = $request->file('payment_screenshot')->store('course-registrations/payments', 'public');
                }

                // Create Registration
                $courseRegistration = CourseRegistration::create([
                    'course_id' => $course->id,
                    'course_variation_id' => null, // Landing page typically implies base course
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'status' => $isPaidCourse ? 'pending' : 'confirmed',
                    'payment_gateway_id' => $isPaidCourse ? $request->payment_gateway_id : null,
                    'transaction_id' => $isPaidCourse ? $request->transaction_id : null,
                    'payment_screenshot' => $paymentScreenshot,
                    'payment_status' => $isPaidCourse ? 'pending' : 'verified',
                    'enrollment_type' => 'online',
                ]);

                // Load relationships
                $courseRegistration->load('course', 'paymentGateway');

                // Chain jobs: Generate PDF first, then send email
                GenerateCourseEnrollmentInvoicePdfJob::withChain([
                    new SendCourseEnrollmentInvoiceJob($courseRegistration, $totalPrice)
                ])->dispatch($courseRegistration, $totalPrice);

                // Redirect back to Landing Page with Success
                return redirect()->route('landing-page.show', $landingPage->slug)
                    ->with('registration_success', true)
                    ->with('registration_id', $courseRegistration->id)
                    ->with('is_new_user', $isNewUser);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit registration. Please try again. ' . $e->getMessage());
        }
    }
}
