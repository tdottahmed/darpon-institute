<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CustomPageController extends Controller
{
    public function index()
    {
        $pages = CustomPage::latest()->paginate(10);
        return view('admin.custom_pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.custom_pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');
        
        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $count = 1;
        while (CustomPage::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        CustomPage::create($data);

        return redirect()->route('admin.custom-pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(CustomPage $customPage)
    {
        return view('admin.custom_pages.edit', compact('customPage'));
    }

    public function update(Request $request, CustomPage $customPage)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        $originalSlug = $data['slug'];
        $count = 1;
        while (CustomPage::where('slug', $data['slug'])->where('id', '!=', $customPage->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $count;
            $count++;
        }

        $customPage->update($data);

        return redirect()->route('admin.custom-pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CustomPage $customPage)
    {
        $customPage->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}
