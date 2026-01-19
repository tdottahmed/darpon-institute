<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrontendContent;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        $contents = FrontendContent::where('section', 'about_page')
            ->get()
            ->keyBy('key');

        return view('admin.about.index', [
            'contents' => $contents
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'page_title' => 'required|array',
            'page_title.en' => 'required|string|max:255',
            'page_title.bn' => 'nullable|string|max:255',
            'page_subtitle' => 'nullable|array',
            'page_subtitle.en' => 'nullable|string',
            'page_subtitle.bn' => 'nullable|string',
            'content' => 'nullable|array',
            'content.en' => 'nullable|string',
            'content.bn' => 'nullable|string',
            // Sidebar Title
            'sidebar_title' => 'nullable|array',
            'sidebar_title.en' => 'nullable|string',
            'sidebar_title.bn' => 'nullable|string',
            // Sidebar Item 1
            'sidebar_item_1_title' => 'nullable|array',
            'sidebar_item_1_title.en' => 'nullable|string',
            'sidebar_item_1_title.bn' => 'nullable|string',
            'sidebar_item_1_text' => 'nullable|array',
            'sidebar_item_1_text.en' => 'nullable|string',
            'sidebar_item_1_text.bn' => 'nullable|string',
            // Sidebar Item 2
            'sidebar_item_2_title' => 'nullable|array',
            'sidebar_item_2_title.en' => 'nullable|string',
            'sidebar_item_2_title.bn' => 'nullable|string',
            'sidebar_item_2_text' => 'nullable|array',
            'sidebar_item_2_text.en' => 'nullable|string',
            'sidebar_item_2_text.bn' => 'nullable|string',
            // Sidebar Item 3
            'sidebar_item_3_title' => 'nullable|array',
            'sidebar_item_3_title.en' => 'nullable|string',
            'sidebar_item_3_title.bn' => 'nullable|string',
            'sidebar_item_3_text' => 'nullable|array',
            'sidebar_item_3_text.en' => 'nullable|string',
            'sidebar_item_3_text.bn' => 'nullable|string',
        ]);

        foreach ($data as $key => $values) {
            FrontendContent::updateOrCreate(
                ['section' => 'about_page', 'key' => $key],
                [
                    'value' => [
                        'en' => $values['en'] ?? '',
                        'bn' => $values['bn'] ?? '',
                    ],
                    'type' => $key === 'content' ? 'textarea' : 'text'
                ]
            );
        }

        // Clear cache
        Cache::forget('frontend_content_en');
        Cache::forget('frontend_content_bn');

        return redirect()->route('admin.about.index')
            ->with('success', 'About page content updated successfully.');
    }
}
