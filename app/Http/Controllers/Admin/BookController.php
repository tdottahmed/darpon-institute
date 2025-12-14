<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(10)->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books',
            'author' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'tags' => 'nullable|string', // Comma separated
            'cover_image' => 'nullable|image|max:2048', // 2MB
            'preview_images' => 'nullable|array',
            'preview_images.*' => 'image|max:2048', // Each image max 2MB
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'boolean',
        ]);

        // Handle file uploads
        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Handle multiple preview images
        $previewImages = [];
        if ($request->hasFile('preview_images')) {
            foreach ($request->file('preview_images') as $image) {
                $previewImages[] = $image->store('books/previews', 'public');
            }
        }
        $validated['preview_images'] = $previewImages;

        // Process tags
        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('status', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:books,slug,' . $book->id,
            'author' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'tags' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'preview_images' => 'nullable|array',
            'preview_images.*' => 'image|max:2048',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // Handle multiple preview images
        $previewImages = [];

        // Keep existing preview images if they're in the request
        if ($request->has('existing_preview_images') && is_array($request->existing_preview_images)) {
            foreach ($request->existing_preview_images as $existingImage) {
                // Extract the path from the full URL
                $path = str_replace(Storage::disk('public')->url(''), '', $existingImage);
                $path = str_replace('/storage/', '', $path);
                if ($path && Storage::disk('public')->exists($path)) {
                    $previewImages[] = $path;
                }
            }
        }

        // Add new preview images if uploaded
        if ($request->hasFile('preview_images')) {
            foreach ($request->file('preview_images') as $image) {
                $previewImages[] = $image->store('books/previews', 'public');
            }
        }

        // Delete old preview images that are not in the new list
        if ($book->preview_images && is_array($book->preview_images)) {
            foreach ($book->preview_images as $oldImage) {
                if (!in_array($oldImage, $previewImages)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        $validated['preview_images'] = $previewImages;

        // Process tags
        if (isset($validated['tags']) && !empty($validated['tags'])) {
            $validated['tags'] = array_filter(array_map('trim', explode(',', $validated['tags'])));
        } else {
            $validated['tags'] = [];
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('status', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Delete preview images
        if ($book->preview_images && is_array($book->preview_images)) {
            foreach ($book->preview_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('status', 'Book deleted successfully.');
    }
}
