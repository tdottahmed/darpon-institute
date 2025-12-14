<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VideoBlog::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        $videoBlogs = $query->latest()->paginate(10)->withQueryString();

        return view('admin.video_blogs.index', compact('videoBlogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.video_blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:video_blogs',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'video_type' => 'required|in:upload,youtube',
            'video_file' => 'nullable|required_if:video_type,upload|file|mimetypes:video/mp4,video/quicktime|max:51200', // 50MB
            'video_url' => 'nullable|required_if:video_type,youtube|url',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('video_blogs/thumbnails', 'public');
        }

        if ($request->hasFile('video_file') && $request->video_type === 'upload') {
            $validated['video_file'] = $request->file('video_file')->store('video_blogs/videos', 'public');
        }

        // Process tags
        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        VideoBlog::create($validated);

        return redirect()->route('admin.video-blogs.index')
            ->with('status', 'Video Blog created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoBlog $videoBlog)
    {
        return view('admin.video_blogs.edit', compact('videoBlog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoBlog $videoBlog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:video_blogs,slug,' . $videoBlog->id,
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'video_type' => 'required|in:upload,youtube',
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'video_url' => 'nullable|required_if:video_type,youtube|url',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($videoBlog->thumbnail) {
                Storage::disk('public')->delete($videoBlog->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('video_blogs/thumbnails', 'public');
        }

        if ($request->video_type === 'upload') {
            if ($request->hasFile('video_file')) {
                if ($videoBlog->video_file) {
                    Storage::disk('public')->delete($videoBlog->video_file);
                }
                $validated['video_file'] = $request->file('video_file')->store('video_blogs/videos', 'public');
            }
            // Clear URL if switching to upload and no new file (keep old file) or new file uploaded
            $validated['video_url'] = null;
        } else {
            // YouTube
            // If switching to youtube, delete old video file
            if ($videoBlog->video_file) {
                 Storage::disk('public')->delete($videoBlog->video_file);
                 $validated['video_file'] = null;
            }
        }

        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        $videoBlog->update($validated);

        return redirect()->route('admin.video-blogs.index')
            ->with('status', 'Video Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoBlog $videoBlog)
    {
        if ($videoBlog->thumbnail) {
            Storage::disk('public')->delete($videoBlog->thumbnail);
        }

        if ($videoBlog->video_file) {
            Storage::disk('public')->delete($videoBlog->video_file);
        }

        $videoBlog->delete();

        return redirect()->route('admin.video-blogs.index')
            ->with('status', 'Video Blog deleted successfully.');
    }
}
