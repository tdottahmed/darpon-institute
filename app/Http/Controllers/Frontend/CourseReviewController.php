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

        // Ensure user is enrolled
        if (!$course->isEnrolled(Auth::user())) {
             return back()->with('error', 'You must be enrolled in this course to leave a review.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Auto-approve for now
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
