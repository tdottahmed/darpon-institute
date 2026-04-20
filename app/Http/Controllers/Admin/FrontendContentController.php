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

        // Include keys from file-only uploads (no corresponding text input)
        $uploadedFiles = $request->file('fields', []);
        $allKeys = array_unique(array_merge(array_keys($fields), array_keys($uploadedFiles)));

        foreach ($allKeys as $key) {
            $fieldData = $fields[$key] ?? [];

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
                    if (!$content->type && !empty($fieldData["{$lang}_existing"])) {
                        $content->type = 'image';
                    }
                } elseif (array_key_exists($lang, $fieldData)) {
                    $value = $fieldData[$lang];
                    $currentValue[$lang] = $value === null ? '' : $value;
                }
            }

            // For image fields: sync bn from en when bn is empty (language-agnostic images)
            if ($content->type === 'image' && !empty($currentValue['en']) && empty($currentValue['bn'])) {
                $currentValue['bn'] = $currentValue['en'];
            }

            // Preserve type if it exists, otherwise determine from field data
            if (!$content->exists && !$content->type) {
                $existing = FrontendContent::where('section', $section)->where('key', $key)->first();
                $content->type = $existing ? $existing->type : 'text';
            }

            $content->value = $currentValue;
            $content->save();
        }

        $this->forgetFrontendContentCache();

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

        $this->forgetFrontendContentCache();

        return redirect()->route('admin.frontend-content.index', ['section' => $section])
            ->with('success', 'Content item removed successfully.');
    }

    private function forgetFrontendContentCache(): void
    {
        $locales = config('app.available_locales', ['en', 'bn']);
        foreach ($locales as $locale) {
            \Illuminate\Support\Facades\Cache::forget("frontend_content_{$locale}");
        }
    }
}
