<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FrontendContent;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class FrontendContentController extends Controller
{
    public function index()
    {
        $contents = FrontendContent::all()->groupBy('section');
        return view('admin.frontend_content.index', [
            'contents' => $contents
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'key' => 'required|string',
            // value can be array or null, strict validation depends on requirements
        ]);

        $content = FrontendContent::firstOrNew([
            'section' => $request->input('section'),
            'key' => $request->input('key')
        ]);

        $currentValue = $content->value;
        if (!is_array($currentValue)) {
            $currentValue = ['en' => (string)$currentValue, 'bn' => ''];
        }
        $newValue = $request->input('value', []);
        
        // Handle Files
        // Use separate input names for files if arrays are tricky, or handle value.en as file
        foreach (['en', 'bn'] as $lang) {
             if ($request->hasFile("value.{$lang}")) {
                $path = $request->file("value.{$lang}")->store('frontend_content', 'public');
                $currentValue[$lang] = Storage::url($path);
                $content->type = 'image';
            } elseif (isset($newValue[$lang])) {
                // Only update text if provided (and not a file upload)
                if (!is_file($newValue[$lang])) { 
                     // Check if it's text. If previous type was image, and we are sending string, it might be the old URL or new text.
                     // But here we rely on type.
                     $currentValue[$lang] = $newValue[$lang];
                }
            }
        }
        
        // If first time and undetermined type (shouldn't happen with seed, but safety)
        if (!$content->exists && !$content->type) {
             $content->type = 'text';
        }

        $content->value = $currentValue;
        $content->save();

        // Clear cache for all supported locales
        \Illuminate\Support\Facades\Cache::forget('frontend_content_en');
        \Illuminate\Support\Facades\Cache::forget('frontend_content_bn');

        return back()->with('success', 'Content updated successfully.');
    }
}
