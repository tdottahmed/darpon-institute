<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateCourseEnrollmentInvoicePdfJob;
use App\Jobs\SendCourseEnrollmentInvoiceJob;
use App\Mail\NewUserPasswordMail;
use App\Models\Course;
use App\Models\CourseRegistration;
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
            'course' => $course,
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
        ];

        $messages = [
            'email.required' => 'Email address is required. We need this to send your login credentials.',
            'email.email' => 'Please provide a valid email address.',
            'payment_gateway_id.required' => 'Please select a payment method.',
            'transaction_id.required' => 'Please enter your transaction ID.',
        ];

        // Use discounted price so free courses (after discount) are treated as free
        if ($course->discounted_price > 0) {
            $rules['payment_gateway_id'] = 'required|exists:payment_gateways,id';
            $rules['transaction_id'] = 'required|string|max:255';
        }

        $request->validate($rules, $messages);

        try {
            return DB::transaction(function () use ($request, $course) {
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
                $isPaidCourse = $course->discounted_price > 0;

                if ($isPaidCourse && $request->hasFile('payment_screenshot')) {
                    $paymentScreenshot = $request->file('payment_screenshot')->store('course-registrations/payments', 'public');
                }

                $courseRegistration = CourseRegistration::create([
                    'course_id' => $course->id,
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

                // Calculate total price for invoice
                $totalPrice = $course->discounted_price ?? $course->price ?? 0;

                // Chain jobs: Generate PDF first, then send email
                GenerateCourseEnrollmentInvoicePdfJob::withChain([
                    new SendCourseEnrollmentInvoiceJob($courseRegistration, $totalPrice)
                ])->dispatch($courseRegistration, $totalPrice);

                if (isset($isPaidCourse) && !$isPaidCourse) {
                    $message = 'Enrollment completed successfully! No payment required.';
                } else {
                    $message = 'Registration submitted successfully! We will contact you soon.';
                }

                $message .= ' An invoice has been sent to your email address.';

                if ($isNewUser) {
                    $message .= ' An account has been created for you. Check your email for login credentials.';
                }

                return redirect()->route('courses.show', $course->slug)
                    ->with('success', $message);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit registration. Please try again. ' . $e->getMessage());
        }
    }
}
