<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FrontendController extends Controller
{

    public function index(): Response|RedirectResponse
    {
        $courses = Course::where('status', true)
            ->latest()
            ->take(6)->get();

        return Inertia::render('Home', [
            'courses' => $courses,
        ]);
    }

    /**
     * Show all courses.
     */
    public function courses(Request $request): Response
    {
        $query = Course::where('status', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by tags
        if ($request->has('tag') && $request->tag) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $courses = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => [
                'search' => $request->search,
                'tag' => $request->tag,
            ],
        ]);
    }

    /**
     * Show a single course.
     */
    public function showCourse(Course $course): Response|RedirectResponse
    {
        // Only show active courses
        if (!$course->status) {
            abort(404);
        }

        // Get related courses (same tags or random)
        $relatedCourses = Course::where('status', true)
            ->where('id', '!=', $course->id)
            ->when($course->tags, function ($query) use ($course) {
                foreach ($course->tags as $tag) {
                    $query->orWhereJsonContains('tags', $tag);
                }
            })
            ->limit(3)
            ->get();

        // If not enough related courses, fill with random
        if ($relatedCourses->count() < 3) {
            $randomCourses = Course::where('status', true)
                ->where('id', '!=', $course->id)
                ->whereNotIn('id', $relatedCourses->pluck('id'))
                ->limit(3 - $relatedCourses->count())
                ->get();
            $relatedCourses = $relatedCourses->merge($randomCourses);
        }

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
        ]);
    }

    /**
     * Show all books.
     */
    public function books(Request $request): Response
    {
        $query = Book::where('status', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by tags
        if ($request->has('tag') && $request->tag) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $books = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('Books/Index', [
            'books' => $books,
            'filters' => [
                'search' => $request->search,
                'tag' => $request->tag,
            ],
        ]);
    }

    /**
     * Show a single book.
     */
    public function showBook(Book $book): Response|RedirectResponse
    {
        // Only show active books
        if (!$book->status) {
            abort(404);
        }

        // Get related books (same tags or random)
        $relatedBooks = Book::where('status', true)
            ->where('id', '!=', $book->id)
            ->when($book->tags, function ($query) use ($book) {
                foreach ($book->tags as $tag) {
                    $query->orWhereJsonContains('tags', $tag);
                }
            })
            ->limit(3)
            ->get();

        // If not enough related books, fill with random
        if ($relatedBooks->count() < 3) {
            $randomBooks = Book::where('status', true)
                ->where('id', '!=', $book->id)
                ->whereNotIn('id', $relatedBooks->pluck('id'))
                ->limit(3 - $relatedBooks->count())
                ->get();
            $relatedBooks = $relatedBooks->merge($randomBooks);
        }

        return Inertia::render('Books/Show', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }

    /**
     * Show the frontend dashboard.
     */
    public function dashboard(): Response|RedirectResponse
    {
        return Inertia::render('Dashboard');
    }
}
