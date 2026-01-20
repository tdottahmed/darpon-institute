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
        // Light Logo
        if ($request->hasFile('logo_light')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('logo_light');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoLightPath = $request->file('logo_light')->store('logos/light', 'public');
            Setting::set('logo_light', $logoLightPath);
        } elseif ($request->filled('logo_light_existing')) {
            // Preserve existing logo
            $existingValue = $request->input('logo_light_existing');
            // Extract storage path from URL if it's a full URL
            $storagePath = $this->extractStoragePath($existingValue);
            if ($storagePath) {
                Setting::set('logo_light', $storagePath);
            }
        }
        // Note: If neither file nor existing value is provided, logo_light remains unchanged

        // Dark Logo
        if ($request->hasFile('logo_dark')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('logo_dark');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoDarkPath = $request->file('logo_dark')->store('logos/dark', 'public');
            Setting::set('logo_dark', $logoDarkPath);
        } elseif ($request->filled('logo_dark_existing')) {
            // Preserve existing logo
            $existingValue = $request->input('logo_dark_existing');
            // Extract storage path from URL if it's a full URL
            $storagePath = $this->extractStoragePath($existingValue);
            if ($storagePath) {
                Setting::set('logo_dark', $storagePath);
            }
        }
        // Note: If neither file nor existing value is provided, logo_dark remains unchanged

        // Remove logo fields from validated array as they're already handled
        unset($validated['logo_light'], $validated['logo_dark'], $validated['logo_light_existing'], $validated['logo_dark_existing']);

        foreach ($validated as $key => $value) {
            // Handle boolean values
            if ($key === 'meta_pixel_enabled') {
                Setting::set($key, $request->has('meta_pixel_enabled') ? 1 : 0);
            } else {
                Setting::set($key, $value);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('status', 'Settings updated successfully.');
    }

    /**
     * Extract storage path from URL or return the path as-is
     */
    private function extractStoragePath($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it's already a storage path (doesn't start with http), return as-is
        if (!str_starts_with($value, 'http')) {
            return $value;
        }

        // Extract path from storage URL
        // Storage::url() creates URLs like: /storage/logos/image.png
        // We need to extract: logos/image.png
        $parsedUrl = parse_url($value);
        $path = $parsedUrl['path'] ?? '';

        // Remove /storage prefix if present
        if (str_starts_with($path, '/storage/')) {
            return substr($path, 9); // Remove '/storage/' (9 characters)
        }

        // If it doesn't match expected pattern, try to extract from the path
        $parts = explode('/', trim($path, '/'));
        if (count($parts) >= 2 && $parts[0] === 'storage') {
            array_shift($parts); // Remove 'storage'
            return implode('/', $parts);
        }

        // Fallback: return as-is if we can't parse it
        return $value;
    }
}
