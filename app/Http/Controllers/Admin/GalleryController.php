<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $galleries = Gallery::ordered()->paginate(24)->withQueryString();

        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array|min:1',
            'images.*.title' => 'required|string|max:255',
            'images.*.image' => 'required|image|mimes:jpeg,jpg,png,gif|max:5120',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',
        ]);

        $uploadedImages = [];
        $maxOrder = Gallery::max('order') ?? 0;
        $order = isset($validated['order']) ? (int) $validated['order'] : $maxOrder + 1;

        foreach ($validated['images'] as $index => $row) {
            $file = $request->file("images.{$index}.image");
            $path = $file->store('galleries', 'public');

            $uploadedImages[] = Gallery::create([
                'image' => $path,
                'title' => $row['title'],
                'order' => $order,
                'status' => $validated['status'] ?? true,
            ]);

            $order++;
        }

        return redirect()->route('admin.galleries.index')
            ->with('status', count($uploadedImages).' image(s) uploaded successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',
        ]);

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('status', 'Gallery image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('status', 'Gallery image deleted successfully.');
    }
}
