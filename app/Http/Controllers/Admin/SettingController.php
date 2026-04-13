<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show the settings form.
     */
    public function index()
    {
        $settings = [
            // Steadfast API
            'steadfast_api_key' => Setting::get('steadfast_api_key'),
            'steadfast_secret_key' => Setting::get('steadfast_secret_key'),

            // Fraud Check Credentials - Pathao
            'pathao_user' => Setting::get('pathao_user'),
            'pathao_password' => Setting::get('pathao_password'),

            // Fraud Check Credentials - Steadfast
            'steadfast_user' => Setting::get('steadfast_user'),
            'steadfast_password' => Setting::get('steadfast_password'),

            // Fraud Check Credentials - Redex
            'redx_phone' => Setting::get('redx_phone'),
            'redx_password' => Setting::get('redx_password'),

            // Meta Pixel
            'meta_pixel_id' => Setting::get('meta_pixel_id'),
            'meta_pixel_enabled' => Setting::get('meta_pixel_enabled', false),

            // Social Media Links
            'social_facebook' => Setting::get('social_facebook'),
            'social_instagram' => Setting::get('social_instagram'),
            'social_twitter' => Setting::get('social_twitter'),
            'social_youtube' => Setting::get('social_youtube'),

            // Company Info
            'company_address' => Setting::get('company_address'),
            'company_phone' => Setting::get('company_phone'),
            'company_email' => Setting::get('company_email'),
            'whatsapp_number' => Setting::get('whatsapp_number'),

            // Logos
            'logo_light' => Setting::get('logo_light'),
            'logo_dark' => Setting::get('logo_dark'),

            // SEO & Analytics
            'sitemap_url' => Setting::get('sitemap_url'),
            'rss_feed_url' => Setting::get('rss_feed_url'),
            'google_analytics_id' => Setting::get('google_analytics_id'),
            'seo_meta_title' => Setting::get('seo_meta_title'),
            'seo_meta_description' => Setting::get('seo_meta_description'),
            'seo_meta_keywords' => Setting::get('seo_meta_keywords'),
            'seo_meta_author' => Setting::get('seo_meta_author'),
            'seo_og_image' => Setting::get('seo_og_image'),
            'header_footer_color_light' => Setting::get('header_footer_color_light', '#ffffff'),
            'header_footer_color_dark' => Setting::get('header_footer_color_dark', '#111827'),
            'header_footer_text_color_light' => Setting::get('header_footer_text_color_light', '#111827'),
            'header_footer_text_color_dark' => Setting::get('header_footer_text_color_dark', '#ffffff'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // Steadfast API
            'steadfast_api_key' => 'nullable|string',
            'steadfast_secret_key' => 'nullable|string',

            // Fraud Check Credentials - Pathao
            'pathao_user' => 'nullable|string|email',
            'pathao_password' => 'nullable|string',

            // Fraud Check Credentials - Steadfast
            'steadfast_user' => 'nullable|string|email',
            'steadfast_password' => 'nullable|string',

            // Fraud Check Credentials - Redex
            'redx_phone' => 'nullable|string',
            'redx_password' => 'nullable|string',

            // Meta Pixel
            'meta_pixel_id' => 'nullable|string|max:255',
            'meta_pixel_enabled' => 'nullable|boolean',

            // Social Media Links
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'social_youtube' => 'nullable|url',

            // Company Info
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:50',

            // Logos
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048',
            'logo_light_existing' => 'nullable|string',
            'logo_dark_existing' => 'nullable|string',

            // SEO & Analytics
            'sitemap_url' => 'nullable|url|max:255',
            'rss_feed_url' => 'nullable|url|max:255',
            'google_analytics_id' => 'nullable|string|max:255',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords' => 'nullable|string|max:500',
            'seo_meta_author' => 'nullable|string|max:255',
            'seo_og_image' => 'nullable|image|max:2048',
            'seo_og_image_existing' => 'nullable|string',
            'header_footer_color_light' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'header_footer_color_dark' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'header_footer_text_color_light' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'header_footer_text_color_dark' => ['nullable', 'string', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
        ]);

        // Handle logo uploads - Process both logos independently
        // IMPORTANT: Only update logos when explicitly provided. Never clear or update if fields are missing.
        // This ensures logos are preserved when updating other settings.

        // Light Logo - Only update if explicitly provided
        if ($request->hasFile('logo_light')) {
            // New file uploaded - update logo
            $oldLogo = Setting::get('logo_light');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoLightPath = $request->file('logo_light')->store('logos/light', 'public');
            Setting::set('logo_light', $logoLightPath);
        } elseif ($request->has('logo_light_existing') && $request->filled('logo_light_existing')) {
            // Only update if the field exists AND has a value
            $existingValue = $request->input('logo_light_existing');
            if (!empty(trim($existingValue))) {
                // Preserve existing logo - extract storage path from URL if needed
                $storagePath = $this->extractStoragePath($existingValue);
                if ($storagePath && !empty(trim($storagePath))) {
                    Setting::set('logo_light', $storagePath);
                }
            }
            // If existing value is empty/null/whitespace, don't update (preserve current value)
        }
        // If logo_light fields are not present in request at all, logo_light remains unchanged

        // Dark Logo - Only update if explicitly provided
        if ($request->hasFile('logo_dark')) {
            // New file uploaded - update logo
            $oldLogo = Setting::get('logo_dark');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoDarkPath = $request->file('logo_dark')->store('logos/dark', 'public');
            Setting::set('logo_dark', $logoDarkPath);
        } elseif ($request->has('logo_dark_existing') && $request->filled('logo_dark_existing')) {
            // Only update if the field exists AND has a value
            $existingValue = $request->input('logo_dark_existing');
            if (!empty(trim($existingValue))) {
                // Preserve existing logo - extract storage path from URL if needed
                $storagePath = $this->extractStoragePath($existingValue);
                if ($storagePath && !empty(trim($storagePath))) {
                    Setting::set('logo_dark', $storagePath);
                }
            }
            // If existing value is empty/null/whitespace, don't update (preserve current value)
        }
        // If logo_dark fields are not present in request at all, logo_dark remains unchanged

        // OG Image - Only update if explicitly provided
        if ($request->hasFile('seo_og_image')) {
            $oldOgImage = Setting::get('seo_og_image');
            if ($oldOgImage && Storage::disk('public')->exists($oldOgImage)) {
                Storage::disk('public')->delete($oldOgImage);
            }
            $ogPath = $request->file('seo_og_image')->store('seo', 'public');
            Setting::set('seo_og_image', $ogPath);
        } elseif ($request->has('seo_og_image_existing') && $request->filled('seo_og_image_existing')) {
            $existingValue = $request->input('seo_og_image_existing');
            if (!empty(trim($existingValue))) {
                $storagePath = $this->extractStoragePath($existingValue);
                if ($storagePath && !empty(trim($storagePath))) {
                    Setting::set('seo_og_image', $storagePath);
                }
            }
        }

        // Remove logo fields from validated array as they're already handled
        unset($validated['logo_light'], $validated['logo_dark'], $validated['logo_light_existing'], $validated['logo_dark_existing'], $validated['seo_og_image'], $validated['seo_og_image_existing']);

        foreach ($validated as $key => $value) {
            // Handle boolean values
            if ($key === 'meta_pixel_enabled') {
                Setting::set($key, $request->has('meta_pixel_enabled') ? 1 : 0);
            } elseif ($request->has($key)) {
                // Only update settings that are explicitly present in the request
                // This prevents clearing values when they're not in the form
                Setting::set($key, $value);
            }
            // If key is not in request, skip it (preserve existing value)
        }

        return redirect()->route('admin.settings.index')
            ->with('status', 'Settings updated successfully.');
    }

    /**
     * Extract storage path from URL or return the path as-is
     * Handles formats like:
     * - /storage/logos/light/image.png -> logos/light/image.png
     * - http://domain.com/storage/logos/light/image.png -> logos/light/image.png
     * - logos/light/image.png -> logos/light/image.png (already correct)
     */
    private function extractStoragePath($value)
    {
        if (empty($value)) {
            return null;
        }

        // Trim whitespace
        $value = trim($value);

        // Handle URLs (http:// or https://)
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            $parsedUrl = parse_url($value);
            $path = $parsedUrl['path'] ?? $value;
        } else {
            // It's already a path
            $path = $value;
        }

        // Remove leading slash
        $path = ltrim($path, '/');

        // Handle multiple /storage/ prefixes (clean them up)
        while (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8); // Remove 'storage/' (8 characters)
        }

        // Remove any remaining /storage/ patterns in the middle
        $path = str_replace('/storage/', '/', $path);
        $path = preg_replace('#/storage/#', '/', $path);

        // If path still starts with storage/, remove it one more time
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        // Return the cleaned path
        return $path ?: null;
    }

    /**
     * Regenerate the XML Sitemap utilizing manual model ingestion 
     * (Provides significantly better compatibility for Inertia.js apps than generic crawlers)
     */
    public function regenerateSitemap()
    {
        try {
            $sitemap = \Spatie\Sitemap\Sitemap::create()
                ->add(\Spatie\Sitemap\Tags\Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
                ->add(\Spatie\Sitemap\Tags\Url::create('/courses')->setPriority(0.9)->setChangeFrequency('daily'))
                ->add(\Spatie\Sitemap\Tags\Url::create('/books')->setPriority(0.9)->setChangeFrequency('daily'))
                ->add(\Spatie\Sitemap\Tags\Url::create('/about')->setPriority(0.7)->setChangeFrequency('monthly'))
                ->add(\Spatie\Sitemap\Tags\Url::create('/contact')->setPriority(0.7)->setChangeFrequency('monthly'));

            // Include dynamic Custom Pages
            if (class_exists(\App\Models\CustomPage::class)) {
                $customPages = \App\Models\CustomPage::where('is_active', true)->get();
                foreach ($customPages as $page) {
                    $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/page/{$page->slug}")->setPriority(0.6)->setChangeFrequency('monthly'));
                }
            }

            // Include Courses
            if (class_exists(\App\Models\Course::class)) {
                // Assuming is_published, status, or is_active fields, if unsure map all
                $courses = \App\Models\Course::all(); 
                foreach ($courses as $course) {
                    $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/courses/{$course->slug}")->setPriority(0.8)->setChangeFrequency('weekly'));
                }
            }

            // Include Books
            if (class_exists(\App\Models\Book::class)) {
                $books = \App\Models\Book::all();
                foreach ($books as $book) {
                    $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/books/{$book->slug}")->setPriority(0.8)->setChangeFrequency('weekly'));
                }
            }

            // Include Landing Pages
            if (class_exists(\App\Models\LandingPage::class)) {
                $landingPages = \App\Models\LandingPage::all();
                foreach ($landingPages as $lp) {
                    $sitemap->add(\Spatie\Sitemap\Tags\Url::create("/lp/{$lp->slug}")->setPriority(0.9)->setChangeFrequency('weekly'));
                }
            }

            $sitemap->writeToFile(public_path('sitemap.xml'));

            // Optionally auto-update the setting link to point to this sitemap
            Setting::set('sitemap_url', url('/sitemap.xml'));

            return redirect()->route('admin.settings.index')
                ->with('status', 'Sitemap generated successfully! It has been natively populated and saved to /sitemap.xml');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Error generating sitemap: ' . $e->getMessage());
        }
    }
}
