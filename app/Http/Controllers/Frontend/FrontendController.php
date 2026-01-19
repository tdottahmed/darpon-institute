<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Book;
use App\Models\VideoBlog;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\BookOrder;
use App\Models\CourseRegistration;
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
            ->where('online_enrollment_enabled', true)
            ->with(['variations' => function ($query) {
                $query->where('status', true)->orderBy('sort_order');
            }])
            ->latest()
            ->take(6)->get();

        $books = Book::where('status', true)
            ->latest()
            ->take(6)->get();

        $videoBlogs = VideoBlog::where('status', true)
            ->latest()
            ->take(3)->get();

        $testimonials = Testimonial::where('status', true)
            ->latest()
            ->take(6)->get();

        $galleries = Gallery::where('status', true)
            ->ordered()
            ->take(8)->get();

        $teachers = \App\Models\Teacher::where('is_active', true)
            ->orderBy('order')
            ->get();

        return Inertia::render('Home', [
            'courses' => $courses,
            'books' => $books,
            'videoBlogs' => $videoBlogs,
            'testimonials' => $testimonials,
            'galleries' => $galleries,
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show all courses.
     */
    public function courses(Request $request): Response
    {
        $query = Course::where('status', true)->where('online_enrollment_enabled', true);

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

        $courses = $query->with('activeVariations')->latest()->paginate(12)->withQueryString();

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
        $relatedCourses = Course::where('status', true)->where('online_enrollment_enabled', true)
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

        $user = Auth::user();
        $userReview = $user ? \App\Models\Testimonial::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first() : null;

        return Inertia::render('Courses/Show', [
            'course' => $course->load(['reviews.user', 'variations' => function ($query) {
                $query->where('status', true)->orderBy('sort_order');
            }]), // Load reviews with user and active variations
            'relatedCourses' => $relatedCourses,
            'isEnrolled' => $course->isEnrolled($user),
            'userReview' => $userReview,
        ]);
    }

    /**
     * Show all books.

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
     * Show all video blogs.
     */
    public function videoBlogs(Request $request): Response
    {
        $query = VideoBlog::where('status', true);

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

        $videoBlogs = $query->latest()->paginate(9)->withQueryString();

        return Inertia::render('VideoBlogs/Index', [
            'videoBlogs' => $videoBlogs,
            'filters' => [
                'search' => $request->search,
                'tag' => $request->tag,
            ],
        ]);
    }

    /**
     * Show a single video blog.
     */
    public function showVideoBlog(VideoBlog $videoBlog): Response|RedirectResponse
    {
        // Only show active video blogs
        if (!$videoBlog->status) {
            abort(404);
        }

        // Get related video blogs (same tags or random)
        $relatedVideoBlogs = VideoBlog::where('status', true)
            ->where('id', '!=', $videoBlog->id)
            ->when($videoBlog->tags, function ($query) use ($videoBlog) {
                foreach ($videoBlog->tags as $tag) {
                    $query->orWhereJsonContains('tags', $tag);
                }
            })
            ->limit(3)
            ->get();

        // If not enough related, fill with random
        if ($relatedVideoBlogs->count() < 3) {
            $randomVideoBlogs = VideoBlog::where('status', true)
                ->where('id', '!=', $videoBlog->id)
                ->whereNotIn('id', $relatedVideoBlogs->pluck('id'))
                ->limit(3 - $relatedVideoBlogs->count())
                ->get();
            $relatedVideoBlogs = $relatedVideoBlogs->merge($randomVideoBlogs);
        }

        return Inertia::render('VideoBlogs/Show', [
            'videoBlog' => $videoBlog,
            'relatedVideoBlogs' => $relatedVideoBlogs,
        ]);
    }

    /**
     * Show the frontend dashboard.
     */
    public function dashboard(): Response|RedirectResponse
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Get book orders by user_id or email (for backward compatibility)
        $bookOrders = BookOrder::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('email', $user->email);
        })
            ->with('book:id,title,slug,cover_image,price')
            ->latest()
            ->get();

        // Get course registrations by matching user email or user_id
        $courseRegistrations = CourseRegistration::where(function ($query) use ($user) {
            $query->where('email', $user->email)
                ->orWhere('user_id', $user->id);
        })
            ->with([
                'course:id,title,slug,thumbnail',
                'courseVariation:id,name,price',
                'paymentGateway:id,name'
            ])
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'bookOrders' => $bookOrders,
            'courseRegistrations' => $courseRegistrations,
        ]);
    }

    /**
     * Show all galleries.
     */
    public function galleries(Request $request): Response
    {
        $galleries = Gallery::where('status', true)
            ->ordered()
            ->paginate(20)->withQueryString();

        return Inertia::render('Galleries/Index', [
            'galleries' => $galleries,
        ]);
    }

    /**
     * Show About page.
     */
    public function about(): Response
    {
        return Inertia::render('About/Index');
    }

    /**
     * Show Contact page.
     */
    public function contact(): Response
    {
        return Inertia::render('Contact/Index');
    }
}
