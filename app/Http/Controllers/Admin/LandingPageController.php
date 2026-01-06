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

        // Handle PDF previews with file uploads
        $this->handlePdfPreviews($request, $validated);

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

        // Handle PDF previews with file uploads
        $this->handlePdfPreviews($request, $validated, $landingPage);

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
     * Store partial data for a new landing page (when creating).
     */
    public function storePartial(Request $request)
    {
        $tab = $request->get('tab', 'basic');
        
        // For basic tab, we need to create the landing page first
        if ($tab === 'basic') {
            $validated = $this->validatePartialRequest($request, $tab);
            
            // Verify book exists
            $book = Book::find($validated['product_id']);
            if (!$book) {
                return redirect()->back()->withErrors(['product_id' => 'Selected book does not exist.'])->withInput();
            }
            
            // Set product type to book
            $validated['product_type'] = 'book';
            
            // Set default status and visibility
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
            
            return redirect(route('admin.landing-pages.edit', $landingPage) . '?tab=' . $tab)
                ->with('success', 'Landing page created. You can now edit other sections.');
        }
        
        // For tabs with file uploads (like PDF, Hero, SEO), require landing page to exist first
        // We can't store file uploads in session, so user must create landing page first
        if (in_array($tab, ['pdf', 'hero', 'seo'])) {
            return redirect()->route('admin.landing-pages.create', ['tab' => $tab])
                ->with('error', 'Please complete Basic Information first to create the landing page. File uploads require an existing landing page.');
        }
        
        // For other tabs without file uploads, validate and store only non-file data
        try {
            $validated = $this->validatePartialRequest($request, $tab);
            
            // Remove any file objects from validated data before storing in session
            $sessionData = [];
            foreach ($validated as $key => $value) {
                if (!($value instanceof \Illuminate\Http\UploadedFile)) {
                    $sessionData[$key] = $value;
                }
            }
            
            // Store only non-file data in session
            if (!empty($sessionData)) {
                session()->put('landing_page_draft.' . $tab, $sessionData);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.landing-pages.create', ['tab' => $tab])
                ->withErrors($e->errors())
                ->withInput($request->except(['pdf_preview_images', 'pdf_preview_files', 'hero_main_image', 'hero_preview_images', 'meta_image']));
        }
        
        return redirect()->route('admin.landing-pages.create', ['tab' => $tab])
            ->with('info', 'Please complete Basic Information first.')
            ->withInput($request->except(['pdf_preview_images', 'pdf_preview_files', 'hero_main_image', 'hero_preview_images', 'meta_image']));
    }

    /**
     * Update partial data for an existing landing page.
     */
    public function updatePartial(Request $request, LandingPage $landing_page)
    {
        $tab = $request->get('tab', 'basic');
        
        $validated = $this->validatePartialRequest($request, $tab, $landing_page);
        
        // Handle specific tab updates
        switch ($tab) {
            case 'pdf':
                $this->handlePdfPreviews($request, $validated, $landing_page);
                break;
            case 'hero':
                $this->handleFileUploads($request, $validated, $landing_page);
                break;
            default:
                $this->handleJsonFields($request, $validated);
                break;
        }
        
        // Update only the fields for this tab
        $landing_page->update($validated);
        
        return redirect(route('admin.landing-pages.edit', $landing_page) . '?tab=' . $tab)
            ->with('success', ucfirst($tab) . ' section updated successfully.');
    }

    /**
     * Validate partial request based on tab.
     */
    protected function validatePartialRequest(Request $request, string $tab, ?LandingPage $landingPage = null)
    {
        $rules = [];
        
        switch ($tab) {
            case 'basic':
                $slugRule = $landingPage
                    ? 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id
                    : 'required|string|max:255|unique:landing_pages';
                $rules = [
                    'title' => 'required|string|max:255',
                    'slug' => $slugRule,
                    'product_id' => 'required|integer|exists:books,id',
                    'status' => 'boolean',
                    'show_hero' => 'boolean',
                    'show_pdf_preview' => 'boolean',
                    'show_book_details' => 'boolean',
                    'show_features' => 'boolean',
                    'show_pricing' => 'boolean',
                    'show_order' => 'boolean',
                ];
                break;
                
            case 'hero':
                $rules = [
                    'hero_english_title' => 'nullable|string|max:500',
                    'hero_bengali_title' => 'nullable|string|max:1000',
                    'hero_main_image' => 'nullable|image|max:2048',
                    'hero_preview_images.*' => 'nullable|image|max:2048',
                ];
                break;
                
            case 'pdf':
                $rules = [
                    'pdf_preview_images.*' => 'nullable|image|max:2048',
                    'pdf_preview_files.*' => 'nullable|file|mimes:pdf|max:10240',
                    'pdf_preview_image_urls.*' => 'nullable|url|max:500',
                    'pdf_preview_urls.*' => 'nullable|url|max:500',
                    'pdf_preview_titles.*' => 'nullable|string|max:255',
                    'pdf_preview_existing_images.*' => 'nullable|string',
                    'pdf_preview_existing_files.*' => 'nullable|string',
                ];
                break;
                
            case 'book-details':
                $rules = [
                    'book_details_title' => 'nullable|string|max:500',
                    'book_details_description' => 'nullable|string',
                    'book_details_specialties' => 'nullable|string',
                    'book_details_extraordinary' => 'nullable|string',
                    'book_details_students_love' => 'nullable|string',
                ];
                break;
                
            case 'features':
                $rules = [
                    'features_list' => 'nullable|string',
                    'target_audience_list' => 'nullable|string',
                    'game_changer_title' => 'nullable|string|max:500',
                    'game_changer_points' => 'nullable|string',
                    'game_changer_conclusion' => 'nullable|string|max:1000',
                ];
                break;
                
            case 'pricing':
                $rules = [
                    'pricing_original_price' => 'nullable|numeric|min:0',
                    'pricing_offer_price' => 'nullable|numeric|min:0',
                    'pricing_description' => 'nullable|string|max:1000',
                    'pricing_note' => 'nullable|string|max:500',
                ];
                break;
                
            case 'order':
                $rules = [
                    'order_section_title' => 'nullable|string|max:255',
                    'order_form_fields' => 'nullable|string',
                    'order_shipping_charge' => 'nullable|numeric|min:0',
                    'order_shipping_note' => 'nullable|string|max:500',
                    'order_payment_note' => 'nullable|string|max:500',
                ];
                break;
                
            case 'seo':
                $rules = [
                    'meta_title' => 'nullable|string|max:255',
                    'meta_description' => 'nullable|string|max:500',
                    'meta_image' => 'nullable|image|max:2048',
                ];
                break;
        }
        
        return $request->validate($rules);
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
            'pdf_preview_images.*' => 'nullable|image|max:2048',
            'pdf_preview_files.*' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_preview_image_urls.*' => 'nullable|url|max:500',
            'pdf_preview_urls.*' => 'nullable|url|max:500',
            'pdf_preview_titles.*' => 'nullable|string|max:255',
            'pdf_preview_existing_images.*' => 'nullable|string',
            'pdf_preview_existing_files.*' => 'nullable|string',
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
     * Handle PDF previews with file uploads.
     */
    protected function handlePdfPreviews(Request $request, array &$validated, ?LandingPage $landingPage = null)
    {
        $pdfPreviews = [];
        $imageUrls = $request->input('pdf_preview_image_urls', []);
        $pdfUrls = $request->input('pdf_preview_urls', []);
        $titles = $request->input('pdf_preview_titles', []);
        $existingImages = $request->input('pdf_preview_existing_images', []);
        $existingPdfs = $request->input('pdf_preview_existing_files', []);

        // Get uploaded images
        $uploadedImages = [];
        if ($request->hasFile('pdf_preview_images')) {
            foreach ($request->file('pdf_preview_images') as $index => $image) {
                if ($image && $image->isValid()) {
                    $uploadedImages[$index] = $image->store('landing_pages/pdf_previews/images', 'public');
                }
            }
        }

        // Get uploaded PDFs
        $uploadedPdfs = [];
        if ($request->hasFile('pdf_preview_files')) {
            foreach ($request->file('pdf_preview_files') as $index => $pdf) {
                if ($pdf && $pdf->isValid()) {
                    $uploadedPdfs[$index] = $pdf->store('landing_pages/pdf_previews/pdfs', 'public');
                }
            }
        }

        // Build PDF previews array
        $maxIndex = max(
            count($imageUrls),
            count($pdfUrls),
            count($titles),
            count($uploadedImages),
            count($uploadedPdfs),
            count($existingImages),
            count($existingPdfs)
        );

        for ($i = 0; $i < $maxIndex; $i++) {
            $image = null;
            $pdfUrl = null;

            // Determine image source (uploaded > URL > existing)
            if (isset($uploadedImages[$i])) {
                $image = $uploadedImages[$i]; // Store relative path, will be converted to URL in frontend
            } elseif (!empty($imageUrls[$i])) {
                $image = $imageUrls[$i];
            } elseif (!empty($existingImages[$i])) {
                // Keep existing image - extract path if it's a full URL
                $existingPath = $existingImages[$i];
                // If it's a full URL with storage, extract the path
                if (strpos($existingPath, '/storage/') !== false) {
                    $image = str_replace(Storage::disk('public')->url(''), '', $existingPath);
                    $image = ltrim($image, '/');
                } elseif (strpos($existingPath, 'storage/') === 0) {
                    $image = $existingPath;
                } elseif (strpos($existingPath, 'http') === 0) {
                    $image = $existingPath; // External URL
                } else {
                    $image = $existingPath;
                }
            }

            // Determine PDF source (uploaded > URL > existing)
            if (isset($uploadedPdfs[$i])) {
                $pdfUrl = $uploadedPdfs[$i]; // Store relative path, will be converted to URL in frontend
            } elseif (!empty($pdfUrls[$i])) {
                $pdfUrl = $pdfUrls[$i];
            } elseif (!empty($existingPdfs[$i])) {
                // Keep existing PDF - extract path if it's a full URL
                $existingPath = $existingPdfs[$i];
                // If it's a full URL with storage, extract the path
                if (strpos($existingPath, '/storage/') !== false) {
                    $pdfUrl = str_replace(Storage::disk('public')->url(''), '', $existingPath);
                    $pdfUrl = ltrim($pdfUrl, '/');
                } elseif (strpos($existingPath, 'storage/') === 0) {
                    $pdfUrl = $existingPath;
                } elseif (strpos($existingPath, 'http') === 0) {
                    $pdfUrl = $existingPath; // External URL
                } else {
                    $pdfUrl = $existingPath;
                }
            }

            // Only add if we have at least image or PDF URL
            if ($image || $pdfUrl) {
                $pdfPreviews[] = [
                    'image' => $image,
                    'pdf_url' => $pdfUrl,
                    'title' => !empty($titles[$i]) ? $titles[$i] : null,
                ];
            }
        }

        // Delete old PDF files if they're being replaced
        if ($landingPage && $landingPage->pdf_previews) {
            $oldPreviews = $landingPage->pdf_previews;
            foreach ($oldPreviews as $oldPreview) {
                // Check if old PDF file exists and is not in new previews
                if (isset($oldPreview['pdf_file']) && strpos($oldPreview['pdf_file'], 'storage/') === 0) {
                    $found = false;
                    foreach ($pdfPreviews as $newPreview) {
                        if (isset($newPreview['pdf_url']) && strpos($newPreview['pdf_url'], $oldPreview['pdf_file']) !== false) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        Storage::disk('public')->delete($oldPreview['pdf_file']);
                    }
                }
            }
        }

        $validated['pdf_previews'] = !empty($pdfPreviews) ? $pdfPreviews : null;
    }

    /**
     * Handle JSON fields from the request.
     */
    protected function handleJsonFields(Request $request, array &$validated)
    {
        $jsonFields = [
            'book_details_specialties',
            'book_details_extraordinary',
            'book_details_students_love',
            'features_list',
            'target_audience_list',
            'game_changer_points',
            'order_form_fields'
        ];
        
        // Note: pdf_previews is handled separately in handlePdfPreviews()

        foreach ($jsonFields as $field) {
            // Handle book_details fields that might come as arrays
            if ($field === 'book_details_specialties' && $request->has('specialties')) {
                $specialties = array_filter($request->input('specialties', []), function($item) {
                    return !empty($item['title']) || !empty($item['description']);
                });
                $validated[$field] = !empty($specialties) ? array_values($specialties) : null;
                continue;
            }
            
            if ($field === 'book_details_extraordinary' && $request->has('extraordinary')) {
                $extraordinary = array_filter($request->input('extraordinary', []), function($item) {
                    return !empty(trim($item));
                });
                $validated[$field] = !empty($extraordinary) ? array_values($extraordinary) : null;
                continue;
            }
            
            if ($field === 'book_details_students_love' && $request->has('students_love')) {
                $studentsLove = array_filter($request->input('students_love', []), function($item) {
                    return !empty(trim($item));
                });
                $validated[$field] = !empty($studentsLove) ? array_values($studentsLove) : null;
                continue;
            }
            
            // Handle features_list that might come as feature_groups array
            if ($field === 'features_list' && $request->has('feature_groups')) {
                $featureGroups = [];
                foreach ($request->input('feature_groups', []) as $group) {
                    if (!empty($group['title']) || !empty($group['items'])) {
                        $items = [];
                        foreach ($group['items'] ?? [] as $item) {
                            if (!empty($item['text'])) {
                                $items[] = [
                                    'text' => $item['text'],
                                    'icon_color' => $item['icon_color'] ?? '#1a237e'
                                ];
                            }
                        }
                        $featureGroups[] = [
                            'title' => $group['title'] ?? '',
                            'items' => $items
                        ];
                    }
                }
                $validated[$field] = !empty($featureGroups) ? $featureGroups : null;
                continue;
            }
            
            // Handle target_audience_list that might come as audience_groups array
            if ($field === 'target_audience_list' && $request->has('audience_groups')) {
                $audienceGroups = [];
                foreach ($request->input('audience_groups', []) as $group) {
                    if (!empty($group['title']) || !empty($group['items'])) {
                        $items = [];
                        foreach ($group['items'] ?? [] as $item) {
                            if (!empty($item['text'])) {
                                $items[] = [
                                    'text' => $item['text'],
                                    'icon_color' => $item['icon_color'] ?? '#1565c0'
                                ];
                            }
                        }
                        $audienceGroups[] = [
                            'title' => $group['title'] ?? '',
                            'items' => $items
                        ];
                    }
                }
                $validated[$field] = !empty($audienceGroups) ? $audienceGroups : null;
                continue;
            }
            
            // Handle game_changer_points that might come as game_changer_points_array
            if ($field === 'game_changer_points' && $request->has('game_changer_points_array')) {
                $points = array_filter($request->input('game_changer_points_array', []), function($item) {
                    return !empty(trim($item));
                });
                $validated[$field] = !empty($points) ? array_values($points) : null;
                continue;
            }
            
            // Handle JSON string fields
            if ($request->filled($field)) {
                $value = $request->$field;
                
                // If already an array, use it directly
                if (is_array($value)) {
                    $validated[$field] = !empty($value) ? $value : null;
                    continue;
                }
                
                // Otherwise, try to decode JSON string
                $jsonString = trim($value);
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
