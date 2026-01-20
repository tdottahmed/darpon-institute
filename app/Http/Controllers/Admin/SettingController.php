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

            // Logos
            'logo_light' => Setting::get('logo_light'),
            'logo_dark' => Setting::get('logo_dark'),
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

            // Logos
            'logo_light' => 'nullable|image|max:2048',
            'logo_dark' => 'nullable|image|max:2048',
            'logo_light_existing' => 'nullable|string',
            'logo_dark_existing' => 'nullable|string',
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

        // Remove logo fields from validated array as they're already handled
        unset($validated['logo_light'], $validated['logo_dark'], $validated['logo_light_existing'], $validated['logo_dark_existing']);

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
}
