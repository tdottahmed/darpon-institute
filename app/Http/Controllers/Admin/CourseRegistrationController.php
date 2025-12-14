<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;

class CourseRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = CourseRegistration::with('course')->latest()->paginate(10);
        return view('admin.course_registrations.index', compact('registrations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseRegistration $courseRegistration)
    {
        $courseRegistration->load('course');
        return view('admin.course_registrations.show', compact('courseRegistration'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseRegistration $courseRegistration)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
        ]);

        $courseRegistration->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Registration status updated successfully.');
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
