<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FrontendContent;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class FrontendContentController extends Controller
{
    public function index(Request $request)
    {
        $contents = FrontendContent::all()->groupBy('section');
        $activeSection = $request->get('section', 'hero'); // Get active section from query param

        return view('admin.frontend_content.index', [
            'contents' => $contents,
            'activeSection' => $activeSection
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'fields' => 'required|array',
        ]);

        $section = $request->input('section');
        $fields = $request->input('fields', []);

        foreach ($fields as $key => $fieldData) {
            $content = FrontendContent::firstOrNew([
                'section' => $section,
                'key' => $key
            ]);

            $currentValue = $content->value;
            if (!is_array($currentValue)) {
                $currentValue = ['en' => (string)$currentValue, 'bn' => ''];
            }

            // Handle file uploads and text values
            foreach (['en', 'bn'] as $lang) {
                // Check if file is uploaded for this language
                $fileInputName = "fields.{$key}.{$lang}";
                if ($request->hasFile($fileInputName)) {
                    $path = $request->file($fileInputName)->store('frontend_content', 'public');
                    $currentValue[$lang] = Storage::url($path);
                    $content->type = 'image';
                } elseif (isset($fieldData["{$lang}_existing"])) {
                    // Preserve existing image if no new file uploaded
                    $currentValue[$lang] = $fieldData["{$lang}_existing"];
                    // Ensure type is set to image if we have an existing image
                    if (!$content->type && !empty($fieldData["{$lang}_existing"])) {
                        $content->type = 'image';
                    }
                } elseif (array_key_exists($lang, $fieldData)) {
                    // Handle text/textarea values (including explicit null to clear)
                    $value = $fieldData[$lang];
                    $currentValue[$lang] = $value === null ? '' : $value;
                }
            }

            // Preserve type if it exists, otherwise determine from field data
            if (!$content->exists && !$content->type) {
                // Try to get type from existing content or default to text
                $existing = FrontendContent::where('section', $section)->where('key', $key)->first();
                $content->type = $existing ? $existing->type : 'text';
            }

            $content->value = $currentValue;
            $content->save();
        }

        // Clear cache for all supported locales
        \Illuminate\Support\Facades\Cache::forget('frontend_content_en');
        \Illuminate\Support\Facades\Cache::forget('frontend_content_bn');

        return redirect()->route('admin.frontend-content.index', ['section' => $section])
            ->with('success', 'Content updated successfully.');
    }
    public function destroy($id)
    {
        $content = FrontendContent::findOrFail($id);
        
        // If it's an image, delete the files
        if ($content->type === 'image' && is_array($content->value)) {
            foreach ($content->value as $url) {
                if ($url) {
                    // Extract path from URL (assuming storage/ URL structure)
                    $path = str_replace('/storage/', '', $url);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }

        $section = $content->section;
        $content->delete();

        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('frontend_content_en');
        \Illuminate\Support\Facades\Cache::forget('frontend_content_bn');

        return redirect()->route('admin.frontend-content.index', ['section' => $section])
            ->with('success', 'Content item removed successfully.');
    }
}
