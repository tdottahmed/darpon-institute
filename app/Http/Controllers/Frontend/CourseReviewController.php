<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Ensure user is enrolled
        if (!$course->isEnrolled($user)) {
             return back()->with('error', 'You must be enrolled in this course to leave a review.');
        }

        \App\Models\Testimonial::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'name' => $user->name,
                'role' => 'Student',
                'review' => $request->comment,
                'rating' => $request->rating,
                'status' => true,
            ]
        );

        return back()->with('success', 'Review submitted successfully!');
    }
}
