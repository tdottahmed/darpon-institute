<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $courses = Course::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'image' => $item->thumbnail,
                    'price' => $item->price,
                    'discount_price' => $item->discounted_price,
                    'type' => 'course',
                    'url' => route('courses.show', $item->slug),
                ];
            });

        $books = Book::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('short_description', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'image' => $item->cover_image,
                    'price' => $item->price,
                    'discount_price' => $item->discounted_price,
                    'type' => 'book',
                    'url' => route('books.show', $item->slug),
                ];
            });

        $results = $courses->concat($books);

        return response()->json($results);
    }
}
