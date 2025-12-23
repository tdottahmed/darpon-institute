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
            'images.*' => 'required|image|max:5120', // 5MB per image
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean',
        ]);

        // Handle multiple image uploads
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('galleries', 'public');

                // Get max order if not provided
                $maxOrder = Gallery::max('order') ?? 0;
                $order = isset($validated['order']) ? $validated['order'] : $maxOrder + 1;

                $gallery = Gallery::create([
                    'image' => $path,
                    'order' => $order,
                    'status' => $validated['status'] ?? true,
                ]);

                $uploadedImages[] = $gallery;

                // Increment order for next image
                $order++;
            }
        }

        return redirect()->route('admin.galleries.index')
            ->with('status', count($uploadedImages) . ' image(s) uploaded successfully.');
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
