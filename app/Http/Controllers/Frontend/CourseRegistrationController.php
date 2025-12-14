<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CourseRegistrationController extends Controller
{
    /**
     * Show the enrollment form for a specific course.
     */
    public function create(Course $course)
    {
        return Inertia::render('Courses/Enroll', [
            'course' => $course
        ]);
    }

    /**
     * Store a newly created registration in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        CourseRegistration::create([
            'course_id' => $course->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'pending',
        ]);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Registration submitted successfully! We will contact you soon.');
    }
}
