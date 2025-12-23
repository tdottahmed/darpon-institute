<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_gateway_id' => 'required|exists:payment_gateways,id',
            'transaction_id' => 'required|string|max:255',
            'payment_screenshot' => 'nullable|image|max:5120', // 5MB
        ], [
            'email.required' => 'Email address is required. We need this to send your login credentials.',
            'email.email' => 'Please provide a valid email address.',
            'payment_gateway_id.required' => 'Please select a payment method.',
            'transaction_id.required' => 'Please enter your transaction ID.',
        ]);

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

                // Handle payment screenshot upload
                $paymentScreenshot = null;
                if ($request->hasFile('payment_screenshot')) {
                    $paymentScreenshot = $request->file('payment_screenshot')->store('course-registrations/payments', 'public');
                }

                CourseRegistration::create([
                    'course_id' => $course->id,
                    'user_id' => $user ? $user->id : null,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'status' => 'pending',
                    'payment_gateway_id' => $request->payment_gateway_id,
                    'transaction_id' => $request->transaction_id,
                    'payment_screenshot' => $paymentScreenshot,
                    'payment_status' => 'pending',
                ]);

                $message = 'Registration submitted successfully! We will contact you soon.';
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
