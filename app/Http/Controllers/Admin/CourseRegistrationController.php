<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\CourseRegistrationInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseRegistration::with('course', 'courseVariation');

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Enrollment type filter
        if ($request->has('enrollment_type') && $request->enrollment_type) {
            $query->where('enrollment_type', $request->enrollment_type);
        }

        // Course filter
        if ($request->has('course_id') && $request->course_id) {
            $query->where('course_id', $request->course_id);
        }

        // Payment status filter
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Installment payment filter
        if ($request->has('is_installment') && $request->is_installment !== '') {
            $query->where('is_installment_payment', $request->is_installment);
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();
        $courses = Course::orderBy('title')->pluck('title', 'id');

        return view('admin.course_registrations.index', compact('registrations', 'courses'));
    }

    /**
     * Show the form for creating a new offline enrollment.
     */
    public function create()
    {
        $courses = Course::where('offline_enrollment_enabled', true)
            ->with('activeVariations')
            ->get();

        // Prepare courses data for JavaScript (use string keys for consistency)
        $coursesData = [];
        foreach ($courses as $course) {
            $coursesData[(string)$course->id] = [
                'id' => $course->id,
                'title' => $course->title,
                'price' => (float)($course->price ?? 0),
                'active_variations' => $course->activeVariations->map(function ($variation) {
                    return [
                        'id' => $variation->id,
                        'name' => $variation->name,
                        'price' => (float)$variation->price,
                        'discounted_price' => (float)$variation->discounted_price,
                    ];
                })->values()->toArray(),
            ];
        }


        // Prepare courses for select dropdown
        $coursesForSelect = $courses->pluck('title', 'id')->toArray();

        return view('admin.course_registrations.create', [
            'courses' => $coursesForSelect,
            'coursesData' => $coursesData,
        ]);
    }

    /**
     * Store a newly created offline enrollment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'course_variation_id' => 'nullable|exists:course_variations,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'is_installment_payment' => 'boolean',
            'installments' => 'required_if:is_installment_payment,1|array|min:1',
            'installments.*.installment_number' => 'required_with:installments|integer|min:1',
            'installments.*.amount' => 'required_with:installments|numeric|min:0',
            'installments.*.due_date' => 'required_with:installments|date',
        ]);

        // Verify course allows offline enrollment
        $course = Course::findOrFail($validated['course_id']);
        if (!$course->offline_enrollment_enabled) {
            return redirect()->back()
                ->withErrors(['course_id' => 'This course does not allow offline enrollment.'])
                ->withInput();
        }

        // Verify variation belongs to course if provided
        if (!empty($validated['course_variation_id'])) {
            $variation = \App\Models\CourseVariation::where('id', $validated['course_variation_id'])
                ->where('course_id', $course->id)
                ->first();

            if (!$variation) {
                return redirect()->back()
                    ->withErrors(['course_variation_id' => 'The selected variation does not belong to the selected course.'])
                    ->withInput();
            }
        }

        $isInstallmentPayment = $request->has('is_installment_payment');

        DB::transaction(function () use ($validated, $isInstallmentPayment) {
            $registration = CourseRegistration::create([
                'course_id' => $validated['course_id'],
                'course_variation_id' => $validated['course_variation_id'] ?? null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
                'status' => $validated['status'],
                'enrollment_type' => 'offline',
                'is_installment_payment' => $isInstallmentPayment ? 1 : 0,
                'payment_status' => 'pending',
            ]);

            // Create installments if installment payment is enabled
            if ($isInstallmentPayment && !empty($validated['installments'])) {
                foreach ($validated['installments'] as $installmentData) {
                    CourseRegistrationInstallment::create([
                        'course_registration_id' => $registration->id,
                        'installment_number' => $installmentData['installment_number'],
                        'amount' => $installmentData['amount'],
                        'due_date' => $installmentData['due_date'],
                        'status' => 'pending',
                    ]);
                }
            }
        });

        return redirect()->route('admin.course-registrations.index')
            ->with('success', 'Offline enrollment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseRegistration $courseRegistration)
    {
        $courseRegistration->load('course', 'courseVariation', 'paymentGateway', 'installments');
        return view('admin.course_registrations.show', compact('courseRegistration'));
    }

    /**
     * Display invoice for the enrollment.
     */
    public function invoice(CourseRegistration $courseRegistration)
    {
        $courseRegistration->load('course', 'courseVariation', 'paymentGateway', 'installments');

        // Calculate total price using accessors
        $totalPrice = 0;
        if ($courseRegistration->courseVariation) {
            $totalPrice = $courseRegistration->courseVariation->discounted_price;
        } elseif ($courseRegistration->course) {
            $totalPrice = $courseRegistration->course->discounted_price ?? $courseRegistration->course->price ?? 0;
        }

        return view('admin.course_registrations.invoice', compact('courseRegistration', 'totalPrice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseRegistration $courseRegistration)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'nullable|string|in:pending,verified,rejected',
        ]);

        $updateData = ['status' => $request->status];
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }

        $courseRegistration->update($updateData);

        return redirect()->back()->with('success', 'Registration status updated successfully.');
    }

    /**
     * Update installment status.
     */
    public function updateInstallment(Request $request, CourseRegistration $courseRegistration, CourseRegistrationInstallment $installment)
    {
        // Verify installment belongs to this registration
        if ($installment->course_registration_id !== $courseRegistration->id) {
            abort(404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,paid,overdue',
            'paid_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'paid' && !$installment->paid_date) {
            $updateData['paid_date'] = $validated['paid_date'] ?? now();
        }

        if (isset($validated['payment_method'])) {
            $updateData['payment_method'] = $validated['payment_method'];
        }

        if (isset($validated['transaction_id'])) {
            $updateData['transaction_id'] = $validated['transaction_id'];
        }

        if (isset($validated['notes'])) {
            $updateData['notes'] = $validated['notes'];
        }

        $installment->update($updateData);

        return redirect()->back()->with('success', 'Installment status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseRegistration $courseRegistration)
    {
        $courseRegistration->delete();
        return redirect()->route('admin.course-registrations.index')->with('success', 'Registration deleted successfully.');
    }
}
