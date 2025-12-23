<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $courses = $query->latest()->paginate(10)->withQueryString();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses',
            'short_description' => 'nullable|string',
            'tags' => 'nullable|string', // Comma separated
            'long_description' => 'nullable|string',
            'duration' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,flat',
            'thumbnail' => 'nullable|image|max:2048', // 2MB
            'preview_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200', // 50MB
            'status' => 'boolean',
        ]);

        // Additional validation: if discount_type is percentage, discount should be max 100
        if (isset($validated['discount_type']) && $validated['discount_type'] === 'percentage' && isset($validated['discount'])) {
            if ($validated['discount'] > 100) {
                return redirect()->back()
                    ->withErrors(['discount' => 'Discount percentage cannot exceed 100%.'])
                    ->withInput();
            }
        }

        // Handle file uploads
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        if ($request->hasFile('preview_video')) {
            $validated['preview_video'] = $request->file('preview_video')->store('courses/videos', 'public');
        }

        // Process tags
        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        // Set default discount_type if not provided
        if (!isset($validated['discount_type']) || empty($validated['discount_type'])) {
            $validated['discount_type'] = 'percentage';
        }

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('status', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:courses,slug,' . $course->id,
            'short_description' => 'nullable|string',
            'tags' => 'nullable|string',
            'long_description' => 'nullable|string',
            'duration' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,flat',
            'thumbnail' => 'nullable|image|max:2048',
            'preview_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'status' => 'boolean',
        ]);

        // Additional validation: if discount_type is percentage, discount should be max 100
        if (isset($validated['discount_type']) && $validated['discount_type'] === 'percentage' && isset($validated['discount'])) {
            if ($validated['discount'] > 100) {
                return redirect()->back()
                    ->withErrors(['discount' => 'Discount percentage cannot exceed 100%.'])
                    ->withInput();
            }
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        if ($request->hasFile('preview_video')) {
            // Delete old
            if ($course->preview_video) {
                Storage::disk('public')->delete($course->preview_video);
            }
            $validated['preview_video'] = $request->file('preview_video')->store('courses/videos', 'public');
        }

        // Process tags
        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        // Set default discount_type if not provided
        if (!isset($validated['discount_type']) || empty($validated['discount_type'])) {
            $validated['discount_type'] = $course->discount_type ?? 'percentage';
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('status', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        if ($course->preview_video) {
            Storage::disk('public')->delete($course->preview_video);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('status', 'Course deleted successfully.');
    }
}
