<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
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
        $query = LandingPage::with('book');

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
        $books = Book::where('status', true)->orderBy('title')->pluck('title', 'id');

        return view('admin.landing_pages.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Verify book exists
        $book = Book::find($validated['product_id']);
        if (!$book) {
            return redirect()->back()->withErrors(['product_id' => 'Selected book does not exist.'])->withInput();
        }

        // Set product type to book
        $validated['product_type'] = 'book';

        // Handle file uploads
        $this->handleFileUploads($request, $validated);

        // Handle JSON fields
        $this->handleJsonFields($request, $validated);

        // Set default status and visibility (default to true for new pages)
        $validated['status'] = $request->has('status') ? 1 : 1;
        $validated['show_hero'] = $request->has('show_hero') ? 1 : 1;
        $validated['show_pdf_preview'] = $request->has('show_pdf_preview') ? 1 : 1;
        $validated['show_book_details'] = $request->has('show_book_details') ? 1 : 1;
        $validated['show_features'] = $request->has('show_features') ? 1 : 1;
        $validated['show_pricing'] = $request->has('show_pricing') ? 1 : 1;
        $validated['show_order'] = $request->has('show_order') ? 1 : 1;

        // Initialize default content for empty fields before creating
        $landingPage = new LandingPage($validated);
        $this->initializeDefaultContent($landingPage, $book);
        $landingPage->save();

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LandingPage $landingPage)
    {
        $landingPage->load('book');
        return view('admin.landing_pages.show', compact('landingPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingPage $landingPage)
    {
        $books = Book::where('status', true)->orderBy('title')->pluck('title', 'id');
        $landingPage->load('book');

        return view('admin.landing_pages.edit', compact('landingPage', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        $validated = $this->validateRequest($request, $landingPage);

        // Verify book exists
        $book = Book::find($validated['product_id']);
        if (!$book) {
            return redirect()->back()->withErrors(['product_id' => 'Selected book does not exist.'])->withInput();
        }

        // Set product type to book
        $validated['product_type'] = 'book';

        // Handle file uploads and removals
        $this->handleFileUploads($request, $validated, $landingPage);

        // Handle JSON fields
        $this->handleJsonFields($request, $validated);

        // Set status and visibility
        $validated['status'] = $request->has('status') ? 1 : 0;
        $validated['show_hero'] = $request->has('show_hero') ? 1 : 0;
        $validated['show_pdf_preview'] = $request->has('show_pdf_preview') ? 1 : 0;
        $validated['show_book_details'] = $request->has('show_book_details') ? 1 : 0;
        $validated['show_features'] = $request->has('show_features') ? 1 : 0;
        $validated['show_pricing'] = $request->has('show_pricing') ? 1 : 0;
        $validated['show_order'] = $request->has('show_order') ? 1 : 0;

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
        $this->deleteAssociatedFiles($landingPage);

        $landingPage->delete();

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page deleted successfully.');
    }

    /**
     * Validate the request data.
     */
    protected function validateRequest(Request $request, ?LandingPage $landingPage = null)
    {
        $slugRule = $landingPage
            ? 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id
            : 'required|string|max:255|unique:landing_pages';

        return $request->validate([
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'product_id' => 'required|integer|exists:books,id',
            'hero_title' => 'nullable|string|max:500',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_image' => 'nullable|image|max:2048',
            'hero_main_image' => 'nullable|image|max:2048',
            'hero_english_title' => 'nullable|string|max:500',
            'hero_bengali_title' => 'nullable|string|max:1000',
            'hero_preview_images.*' => 'nullable|image|max:2048',
            'hero_video_type' => 'nullable|in:url,upload',
            'hero_video' => 'nullable|string',
            'hero_video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'pdf_previews' => 'nullable|string',
            'book_details_title' => 'nullable|string|max:500',
            'book_details_description' => 'nullable|string',
            'book_details_specialties' => 'nullable|string',
            'book_details_extraordinary' => 'nullable|string',
            'book_details_students_love' => 'nullable|string',
            'features_list' => 'nullable|string',
            'target_audience_list' => 'nullable|string',
            'game_changer_title' => 'nullable|string|max:500',
            'game_changer_points' => 'nullable|string',
            'game_changer_conclusion' => 'nullable|string|max:1000',
            'pricing_original_price' => 'nullable|numeric|min:0',
            'pricing_offer_price' => 'nullable|numeric|min:0',
            'pricing_description' => 'nullable|string|max:1000',
            'pricing_note' => 'nullable|string|max:500',
            'order_section_title' => 'nullable|string|max:255',
            'order_form_fields' => 'nullable|string',
            'order_shipping_charge' => 'nullable|numeric|min:0',
            'order_shipping_note' => 'nullable|string|max:500',
            'order_payment_note' => 'nullable|string|max:500',
            'custom_description' => 'nullable|string',
            'custom_images.*' => 'nullable|image|max:2048',
            'custom_videos.*' => 'nullable|string',
            'cta_text' => 'nullable|string|max:500',
            'cta_button_text' => 'nullable|string|max:100',
            'status' => 'boolean',
            'show_hero' => 'boolean',
            'show_pdf_preview' => 'boolean',
            'show_book_details' => 'boolean',
            'show_features' => 'boolean',
            'show_pricing' => 'boolean',
            'show_order' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_image' => 'nullable|image|max:2048',
        ]);
    }

    /**
     * Handle file uploads for landing pages.
     */
    protected function handleFileUploads(Request $request, array &$validated, ?LandingPage $landingPage = null)
    {
        // Handle hero images
        if ($request->hasFile('hero_image')) {
            if ($landingPage && $landingPage->hero_image) {
                Storage::disk('public')->delete($landingPage->hero_image);
            }
            $validated['hero_image'] = $request->file('hero_image')->store('landing_pages/hero', 'public');
        } elseif ($landingPage && $request->has('hero_image_remove')) {
            if ($landingPage->hero_image) {
                Storage::disk('public')->delete($landingPage->hero_image);
            }
            $validated['hero_image'] = null;
        }

        if ($request->hasFile('hero_main_image')) {
            if ($landingPage && $landingPage->hero_main_image) {
                Storage::disk('public')->delete($landingPage->hero_main_image);
            }
            $validated['hero_main_image'] = $request->file('hero_main_image')->store('landing_pages/hero', 'public');
        } elseif ($landingPage && $request->has('hero_main_image_remove')) {
            if ($landingPage->hero_main_image) {
                Storage::disk('public')->delete($landingPage->hero_main_image);
            }
            $validated['hero_main_image'] = null;
        }

        // Handle hero preview images
        $heroPreviewImages = $landingPage->hero_preview_images ?? [];
        if ($request->hasFile('hero_preview_images')) {
            foreach ($request->file('hero_preview_images') as $image) {
                $heroPreviewImages[] = $image->store('landing_pages/hero/preview', 'public');
            }
        }
        // Handle preview image removal
        if ($landingPage && $request->has('remove_preview_images')) {
            $imagesToRemove = $request->remove_preview_images;
            foreach ($imagesToRemove as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $heroPreviewImages = array_filter($heroPreviewImages, fn($img) => $img !== $imagePath);
            }
        }
        $validated['hero_preview_images'] = !empty($heroPreviewImages) ? array_values($heroPreviewImages) : null;

        // Handle hero video
        if (($validated['hero_video_type'] ?? null) === 'upload' && $request->hasFile('hero_video_file')) {
            if ($landingPage && $landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
                Storage::disk('public')->delete($landingPage->hero_video);
            }
            $validated['hero_video'] = $request->file('hero_video_file')->store('landing_pages/videos', 'public');
        } elseif (($validated['hero_video_type'] ?? null) === 'url') {
            if ($landingPage && $landingPage->hero_video && $landingPage->hero_video_type === 'upload') {
                Storage::disk('public')->delete($landingPage->hero_video);
            }
            $validated['hero_video'] = $request->hero_video;
        } elseif ($landingPage && $request->has('hero_video_remove')) {
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
        if ($landingPage && $request->has('remove_images')) {
            $imagesToRemove = $request->remove_images;
            foreach ($imagesToRemove as $imagePath) {
                Storage::disk('public')->delete($imagePath);
                $customImages = array_filter($customImages, fn($img) => $img !== $imagePath);
            }
        }
        $validated['custom_images'] = !empty($customImages) ? array_values($customImages) : null;

        // Handle custom videos (URLs)
        if ($request->filled('custom_videos')) {
            $customVideos = array_filter(array_map('trim', $request->custom_videos));
            $validated['custom_videos'] = !empty($customVideos) ? array_values($customVideos) : null;
        } else {
            $validated['custom_videos'] = null;
        }

        // Handle meta image
        if ($request->hasFile('meta_image')) {
            if ($landingPage && $landingPage->meta_image) {
                Storage::disk('public')->delete($landingPage->meta_image);
            }
            $validated['meta_image'] = $request->file('meta_image')->store('landing_pages/meta', 'public');
        } elseif ($landingPage && $request->has('meta_image_remove')) {
            if ($landingPage->meta_image) {
                Storage::disk('public')->delete($landingPage->meta_image);
            }
            $validated['meta_image'] = null;
        }
    }

    /**
     * Handle JSON fields from the request.
     */
    protected function handleJsonFields(Request $request, array &$validated)
    {
        $jsonFields = [
            'pdf_previews',
            'book_details_specialties',
            'book_details_extraordinary',
            'book_details_students_love',
            'features_list',
            'target_audience_list',
            'game_changer_points',
            'order_form_fields'
        ];

        foreach ($jsonFields as $field) {
            if ($request->filled($field)) {
                $jsonString = trim($request->$field);
                if (!empty($jsonString)) {
                    $decoded = json_decode($jsonString, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $validated[$field] = $decoded;
                    } else {
                        // If JSON is invalid, set to null and let validation handle it
                        $validated[$field] = null;
                    }
                } else {
                    $validated[$field] = null;
                }
            } else {
                $validated[$field] = null;
            }
        }
    }

    /**
     * Initialize default content for empty fields.
     */
    protected function initializeDefaultContent(LandingPage $landingPage, Book $book)
    {
        $defaults = LandingPage::getDefaultContent($book);

        foreach ($defaults as $key => $value) {
            if (is_null($landingPage->$key) || $landingPage->$key === '') {
                $landingPage->$key = $value;
            }
        }
    }

    /**
     * Delete all associated files for a landing page.
     */
    protected function deleteAssociatedFiles(LandingPage $landingPage)
    {
        if ($landingPage->hero_image) {
            Storage::disk('public')->delete($landingPage->hero_image);
        }
        if ($landingPage->hero_main_image) {
            Storage::disk('public')->delete($landingPage->hero_main_image);
        }
        if ($landingPage->hero_preview_images) {
            foreach ($landingPage->hero_preview_images as $image) {
                Storage::disk('public')->delete($image);
            }
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
    }
}
