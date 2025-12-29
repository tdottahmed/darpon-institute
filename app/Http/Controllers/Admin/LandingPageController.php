<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Course;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LandingPage::with('course', 'book');

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            }
        }

        // Product type filter
        if ($request->filled('product_type')) {
            $query->where('product_type', $request->product_type);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        $landingPages = $query->latest()->paginate(10)->withQueryString();

        return view('admin.landing_pages.index', compact('landingPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('status', true)->orderBy('title')->pluck('title', 'id');
        $books = Book::where('status', true)->orderBy('title')->pluck('title', 'id');

        return view('admin.landing_pages.create', compact('courses', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages',
            'product_type' => 'required|in:course,book',
            'product_id' => 'required|integer',
            'hero_title' => 'nullable|string|max:500',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image' => 'nullable|image|max:2048',
            'hero_video_type' => 'nullable|in:url,upload',
            'hero_video' => 'nullable|string',
            'hero_video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'custom_description' => 'nullable|string',
            'custom_images.*' => 'nullable|image|max:2048',
            'custom_videos.*' => 'nullable|string',
            'cta_text' => 'nullable|string|max:500',
            'cta_button_text' => 'nullable|string|max:100',
            'status' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_image' => 'nullable|image|max:2048',
        ]);

        // Verify product exists
        if ($validated['product_type'] === 'course') {
            $product = Course::find($validated['product_id']);
            if (!$product) {
                return redirect()->back()->withErrors(['product_id' => 'Selected course does not exist.'])->withInput();
            }
        } else {
            $product = Book::find($validated['product_id']);
            if (!$product) {
                return redirect()->back()->withErrors(['product_id' => 'Selected book does not exist.'])->withInput();
            }
        }

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('landing_pages/hero', 'public');
        }

        // Handle hero video
        if ($validated['hero_video_type'] === 'upload' && $request->hasFile('hero_video_file')) {
            $validated['hero_video'] = $request->file('hero_video_file')->store('landing_pages/videos', 'public');
        } elseif ($validated['hero_video_type'] === 'url') {
            $validated['hero_video'] = $request->hero_video;
        } else {
            $validated['hero_video'] = null;
            $validated['hero_video_type'] = null;
        }

        // Handle custom images
        $customImages = [];
        if ($request->hasFile('custom_images')) {
            foreach ($request->file('custom_images') as $image) {
                $customImages[] = $image->store('landing_pages/images', 'public');
            }
        }
        $validated['custom_images'] = !empty($customImages) ? $customImages : null;

        // Handle custom videos (URLs)
        if ($request->filled('custom_videos')) {
            $customVideos = array_filter(array_map('trim', $request->custom_videos));
            $validated['custom_videos'] = !empty($customVideos) ? array_values($customVideos) : null;
        } else {
            $validated['custom_videos'] = null;
        }

        // Handle meta image
        if ($request->hasFile('meta_image')) {
            $validated['meta_image'] = $request->file('meta_image')->store('landing_pages/meta', 'public');
        }

        // Set default status
        $validated['status'] = $request->has('status') ? 1 : 0;

        LandingPage::create($validated);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LandingPage $landingPage)
    {
        $landingPage->load('course', 'book');
        return view('admin.landing_pages.show', compact('landingPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingPage $landingPage)
    {
        $courses = Course::where('status', true)->orderBy('title')->pluck('title', 'id');
        $books = Book::where('status', true)->orderBy('title')->pluck('title', 'id');
        $landingPage->load('course', 'book');

        return view('admin.landing_pages.edit', compact('landingPage', 'courses', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id,
            'product_type' => 'required|in:course,book',
            'product_id' => 'required|integer',
            'hero_title' => 'nullable|string|max:500',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image' => 'nullable|image|max:2048',
            'hero_video_type' => 'nullable|in:url,upload',
            'hero_video' => 'nullable|string',
            'hero_video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'custom_description' => 'nullable|string',
            'custom_images.*' => 'nullable|image|max:2048',
            'custom_videos.*' => 'nullable|string',
            'cta_text' => 'nullable|string|max:500',
            'cta_button_text' => 'nullable|string|max:100',
            'status' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_image' => 'nullable|image|max:2048',
        ]);

        // Verify product exists
        if ($validated['product_type'] === 'course') {
            $product = Course::find($validated['product_id']);
            if (!$product) {
                return redirect()->back()->withErrors(['product_id' => 'Selected course does not exist.'])->withInput();
            }
        } else {
            $product = Book::find($validated['product_id']);
            if (!$product) {
                return redirect()->back()->withErrors(['product_id' => 'Selected book does not exist.'])->withInput();
            }
        }

        // Handle hero image
        if ($request->hasFile('hero_image')) {
            if ($landingPage->hero_image) {
                Storage::disk('public')->delete($landingPage->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('landing_pages/hero', 'public');
        } elseif ($request->has('hero_image_remove')) {
            if ($landingPage->hero_image) {
                Storage::disk('public')->delete($landingPage->hero_image);
            }
            $validated['hero_image'] = null;
        }

        // Handle hero video
        if ($validated['hero_video_type'] === 'upload' && $request->hasFile('hero_video_file')) {
            if ($landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
                Storage::disk('public')->delete($landingPage->hero_video);
            }
            $validated['hero_video'] = $request->file('hero_video_file')->store('landing_pages/videos', 'public');
        } elseif ($validated['hero_video_type'] === 'url') {
            if ($landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
                Storage::disk('public')->delete($landingPage->hero_video);
            }
            $validated['hero_video'] = $request->hero_video;
        } elseif ($request->has('hero_video_remove')) {
            if ($landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
                Storage::disk('public')->delete($landingPage->hero_video);
            }
            $validated['hero_video'] = null;
            $validated['hero_video_type'] = null;
        }

        // Handle custom images
        $customImages = $landingPage->custom_images ?? [];
        if ($request->hasFile('custom_images')) {
            foreach ($request->file('custom_images') as $image) {
                $customImages[] = $image->store('landing_pages/images', 'public');
            }
        }
        // Handle image removal
        if ($request->has('remove_images')) {
            $imagesToRemove = $request->remove_images;
            foreach ($imagesToRemove as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $customImages = array_filter($customImages, fn($img) => $img !== $imagePath);
            }
        }
        $validated['custom_images'] = !empty($customImages) ? array_values($customImages) : null;

        // Handle custom videos
        if ($request->filled('custom_videos')) {
            $customVideos = array_filter(array_map('trim', $request->custom_videos));
            $validated['custom_videos'] = !empty($customVideos) ? array_values($customVideos) : null;
        } else {
            $validated['custom_videos'] = null;
        }

        // Handle meta image
        if ($request->hasFile('meta_image')) {
            if ($landingPage->meta_image) {
                Storage::disk('public')->delete($landingPage->meta_image);
            }
            $validated['meta_image'] = $request->file('meta_image')->store('landing_pages/meta', 'public');
        } elseif ($request->has('meta_image_remove')) {
            if ($landingPage->meta_image) {
                Storage::disk('public')->delete($landingPage->meta_image);
            }
            $validated['meta_image'] = null;
        }

        // Set status
        $validated['status'] = $request->has('status') ? 1 : 0;

        $landingPage->update($validated);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandingPage $landingPage)
    {
        // Delete associated files
        if ($landingPage->hero_image) {
            Storage::disk('public')->delete($landingPage->hero_image);
        }
        if ($landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
            Storage::disk('public')->delete($landingPage->hero_video);
        }
        if ($landingPage->meta_image) {
            Storage::disk('public')->delete($landingPage->meta_image);
        }
        if ($landingPage->custom_images) {
            foreach ($landingPage->custom_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $landingPage->delete();

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page deleted successfully.');
    }
}
