<?php

namespace App\Services\Seo;

use App\Models\Book;
use App\Models\Course;
use App\Models\CustomPage;
use App\Models\LandingPage;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\VideoBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FrontendSeoResolver
{
    /**
     * @return array{
     *   title: string,
     *   description: ?string,
     *   keywords: ?string,
     *   canonical_url: string,
     *   og_title: string,
     *   og_description: ?string,
     *   og_image: ?string,
     *   og_url: string,
     *   og_type: string,
     *   og_site_name: string,
     *   twitter_card: string,
     *   twitter_title: string,
     *   twitter_description: ?string,
     *   twitter_image: ?string,
     *   json_ld: list<array<string, mixed>>
     * }
     */
    public function resolve(Request $request): array
    {
        $route = $request->route();
        if (!$route) {
            return $this->defaults($request, 'Darpon', null, null, null, 'website', []);
        }

        $name = $route->getName();

        return match ($name) {
            'home' => $this->forHome($request),
            'courses.index' => $this->forCoursesIndex($request),
            'courses.show' => $this->forCourseShow($request, $route->parameter('course')),
            'courses.enroll' => $this->forCourseEnroll($request, $route->parameter('course')),
            'books.index' => $this->forBooksIndex($request),
            'books.show' => $this->forBookShow($request, $route->parameter('book')),
            'books.checkout' => $this->forBookCheckout($request, $route->parameter('book')),
            'video_blogs.index' => $this->forVideoBlogsIndex($request),
            'video_blogs.show' => $this->forVideoBlogShow($request, $route->parameter('videoBlog')),
            'galleries.index' => $this->forGalleriesIndex($request),
            'instructors.index' => $this->forInstructorsIndex($request),
            'instructors.show' => $this->forInstructorShow($request, $route->parameter('instructor')),
            'page.show' => $this->forCustomPage($request, $route->parameter('slug')),
            'why-choose-us' => $this->forStatic($request, __('Why Choose Us'), __('Why Choose Us'), 'website'),
            'about' => $this->forStatic($request, __('About Us'), __('About Us'), 'website'),
            'contact' => $this->forStatic($request, __('Contact'), __('Contact'), 'website'),
            default => $this->defaultsFromRoute($request, $name),
        };
    }

    /**
     * Blade landing pages (/lp/{slug}).
     *
     * @return array<string, mixed>
     */
    public function forLandingPage(LandingPage $landingPage, Request $request): array
    {
        $productTitle = $landingPage->product_type === 'course'
            ? ($landingPage->course?->title ?? $landingPage->title)
            : ($landingPage->book?->title ?? $landingPage->title);

        $title = $this->nonEmpty($landingPage->meta_title) ?? $productTitle;
        $description = $this->nonEmpty($landingPage->meta_description)
            ?? $this->plainExcerpt($landingPage->custom_description);
        $keywords = $this->keywordsFromArray($landingPage->focus_keyphrase_options);
        $ogImage = $this->absoluteImage($landingPage->meta_image) ?? $this->defaultOgImage();
        $canonical = route('landing-page.show', $landingPage->slug, absolute: true);

        $jsonLd = [
            $this->webSiteSchema(),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => $title, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, $keywords, $canonical, $ogImage, 'product', $jsonLd, $request);
    }

    protected function forHome(Request $request): array
    {
        $title = $this->setting('seo_meta_title') ?? config('app.name', 'Darpon');
        $description = $this->setting('seo_meta_description');
        $keywords = $this->setting('seo_meta_keywords');
        $ogImage = $this->absoluteImage($this->setting('seo_og_image')) ?? $this->defaultOgImage();

        $jsonLd = [
            $this->webSiteSchema(),
            ['@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => $title, 'url' => route('home', absolute: true)],
        ];

        return $this->pack($title, $description, $keywords, route('home', absolute: true), $ogImage, 'website', $jsonLd, $request);
    }

    protected function forCoursesIndex(Request $request): array
    {
        $title = __('Courses') . ' | ' . config('app.name');
        $description = __('Browse our English and skills courses.');
        $canonical = route('courses.index', absolute: true);

        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('Courses'), 'url' => $canonical],
        ])];

        return $this->pack($title, $description, null, $canonical, $this->defaultOgImage(), 'website', $jsonLd, $request);
    }

    protected function forCourseShow(Request $request, mixed $course): array
    {
        if (!$course instanceof Course) {
            return $this->defaults($request, 'Course', null, null, null, 'website', []);
        }

        $title = $this->nonEmpty($course->seo_title) ?? $course->title;
        $description = $this->nonEmpty($course->meta_description)
            ?? $this->plainExcerpt($course->short_description ?: $course->long_description);
        $keywords = $this->keywordsFromArray($course->focus_keyphrase_options);
        $ogImage = $this->absoluteImage($course->thumbnail) ?? $this->defaultOgImage();
        $canonical = route('courses.show', $course, absolute: true);

        $jsonLd = [
            $this->webSiteSchema(),
            $this->courseSchema($course, $canonical, $description, $ogImage),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => __('Courses'), 'url' => route('courses.index', absolute: true)],
                ['name' => $course->title, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, $keywords, $canonical, $ogImage, 'article', $jsonLd, $request);
    }

    protected function forCourseEnroll(Request $request, mixed $course): array
    {
        if (!$course instanceof Course) {
            return $this->defaults($request, 'Enroll', null, null, null, 'website', []);
        }

        $title = __('Enroll') . ': ' . $course->title;
        $description = $this->plainExcerpt($course->short_description);
        $canonical = route('courses.enroll', $course, absolute: true);
        $ogImage = $this->absoluteImage($course->thumbnail) ?? $this->defaultOgImage();
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('Courses'), 'url' => route('courses.index', absolute: true)],
            ['name' => $course->title, 'url' => route('courses.show', $course, absolute: true)],
            ['name' => __('Enroll'), 'url' => $canonical],
        ])];

        return $this->pack($title, $description, null, $canonical, $ogImage, 'website', $jsonLd, $request);
    }

    protected function forBooksIndex(Request $request): array
    {
        $title = __('books.title') . ' | ' . config('app.name');
        $description = __('books.subtitle');
        $canonical = route('books.index', absolute: true);
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('books.title'), 'url' => $canonical],
        ])];

        return $this->pack($title, $description, null, $canonical, $this->defaultOgImage(), 'website', $jsonLd, $request);
    }

    protected function forBookShow(Request $request, mixed $book): array
    {
        if (!$book instanceof Book) {
            return $this->defaults($request, 'Book', null, null, null, 'website', []);
        }

        $title = $this->nonEmpty($book->seo_title) ?? $book->title;
        $description = $this->nonEmpty($book->meta_description)
            ?? $this->plainExcerpt($book->short_description ?: $book->long_description);
        $keywords = $this->keywordsFromArray($book->focus_keyphrase_options);
        $ogImage = $this->absoluteImage($book->cover_image) ?? $this->defaultOgImage();
        $canonical = route('books.show', $book, absolute: true);

        $jsonLd = [
            $this->webSiteSchema(),
            $this->bookSchema($book, $canonical, $description, $ogImage),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => __('books.title'), 'url' => route('books.index', absolute: true)],
                ['name' => $book->title, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, $keywords, $canonical, $ogImage, 'article', $jsonLd, $request);
    }

    protected function forBookCheckout(Request $request, mixed $book): array
    {
        if (!$book instanceof Book) {
            return $this->defaults($request, 'Checkout', null, null, null, 'website', []);
        }

        $title = __('Checkout') . ': ' . $book->title;
        $description = $this->plainExcerpt($book->short_description);
        $canonical = route('books.checkout', $book, absolute: true);
        $ogImage = $this->absoluteImage($book->cover_image) ?? $this->defaultOgImage();
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('books.title'), 'url' => route('books.index', absolute: true)],
            ['name' => $book->title, 'url' => route('books.show', $book, absolute: true)],
            ['name' => __('Checkout'), 'url' => $canonical],
        ])];

        return $this->pack($title, $description, null, $canonical, $ogImage, 'website', $jsonLd, $request);
    }

    protected function forVideoBlogsIndex(Request $request): array
    {
        $title = __('Video Blogs') . ' | ' . config('app.name');
        $canonical = route('video_blogs.index', absolute: true);
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('Video Blogs'), 'url' => $canonical],
        ])];

        return $this->pack($title, null, null, $canonical, $this->defaultOgImage(), 'website', $jsonLd, $request);
    }

    protected function forVideoBlogShow(Request $request, mixed $videoBlog): array
    {
        if (!$videoBlog instanceof VideoBlog) {
            return $this->defaults($request, 'Video', null, null, null, 'website', []);
        }

        $title = $videoBlog->title . ' | ' . config('app.name');
        $description = $this->plainExcerpt($videoBlog->short_description ?: $videoBlog->long_description);
        $ogImage = $this->absoluteImage($videoBlog->thumbnail) ?? $this->defaultOgImage();
        $canonical = route('video_blogs.show', $videoBlog, absolute: true);
        $jsonLd = [
            $this->webSiteSchema(),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => __('Video Blogs'), 'url' => route('video_blogs.index', absolute: true)],
                ['name' => $videoBlog->title, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, null, $canonical, $ogImage, 'article', $jsonLd, $request);
    }

    protected function forGalleriesIndex(Request $request): array
    {
        $title = __('Gallery') . ' | ' . config('app.name');
        $canonical = route('galleries.index', absolute: true);
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('Gallery'), 'url' => $canonical],
        ])];

        return $this->pack($title, null, null, $canonical, $this->defaultOgImage(), 'website', $jsonLd, $request);
    }

    protected function forInstructorsIndex(Request $request): array
    {
        $title = __('Instructors') . ' | ' . config('app.name');
        $canonical = route('instructors.index', absolute: true);
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => __('Instructors'), 'url' => $canonical],
        ])];

        return $this->pack($title, null, null, $canonical, $this->defaultOgImage(), 'website', $jsonLd, $request);
    }

    protected function forInstructorShow(Request $request, mixed $instructor): array
    {
        if (!$instructor instanceof Teacher) {
            return $this->defaults($request, 'Instructor', null, null, null, 'profile', []);
        }

        $title = $this->nonEmpty($instructor->seo_title) ?? $instructor->name;
        $description = $this->nonEmpty($instructor->meta_description)
            ?? $this->plainExcerpt($instructor->description);
        $keywords = $this->keywordsFromArray($instructor->focus_keyphrase_options);
        $ogImage = $this->absoluteImage($instructor->image_path) ?? $this->defaultOgImage();
        $canonical = route('instructors.show', $instructor, absolute: true);

        $jsonLd = [
            $this->webSiteSchema(),
            $this->personSchema($instructor, $canonical, $description, $ogImage),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => __('Instructors'), 'url' => route('instructors.index', absolute: true)],
                ['name' => $instructor->name, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, $keywords, $canonical, $ogImage, 'profile', $jsonLd, $request);
    }

    protected function forCustomPage(Request $request, mixed $slug): array
    {
        $page = CustomPage::where('slug', $slug)->where('is_active', true)->first();
        if (!$page) {
            return $this->defaults($request, config('app.name'), null, null, null, 'website', []);
        }

        $title = $this->nonEmpty($page->meta_title) ?? $page->title;
        $description = $this->nonEmpty($page->meta_description) ?? $this->plainExcerpt($page->content);
        $keywords = $this->keywordsFromArray($page->focus_keyphrase_options);
        $canonical = route('page.show', $page->slug, absolute: true);
        $ogImage = $this->defaultOgImage();
        $jsonLd = [
            $this->webSiteSchema(),
            $this->breadcrumbSchema([
                ['name' => 'Home', 'url' => route('home', absolute: true)],
                ['name' => $page->title, 'url' => $canonical],
            ]),
        ];

        return $this->pack($title, $description, $keywords, $canonical, $ogImage, 'article', $jsonLd, $request);
    }

    protected function forStatic(Request $request, string $pageTitle, string $breadcrumbLabel, string $ogType): array
    {
        $title = $pageTitle . ' | ' . config('app.name');
        $canonical = $request->url();
        $jsonLd = [$this->webSiteSchema(), $this->breadcrumbSchema([
            ['name' => 'Home', 'url' => route('home', absolute: true)],
            ['name' => $breadcrumbLabel, 'url' => $canonical],
        ])];

        return $this->pack($title, $this->setting('seo_meta_description'), null, $canonical, $this->defaultOgImage(), $ogType, $jsonLd, $request);
    }

    protected function defaultsFromRoute(Request $request, ?string $routeName): array
    {
        $site = config('app.name', 'Darpon');
        $title = $site;
        if ($routeName) {
            $title = Str::title(str_replace('.', ' ', $routeName)) . ' | ' . $site;
        }

        return $this->defaults($request, $title, $this->setting('seo_meta_description'), $this->setting('seo_meta_keywords'), $this->defaultOgImage(), 'website', [$this->webSiteSchema()]);
    }

    /**
     * @param  list<array<string, mixed>>  $jsonLd
     * @return array<string, mixed>
     */
    protected function defaults(Request $request, string $title, ?string $description, ?string $keywords, ?string $ogImageUrl, string $ogType, array $jsonLd): array
    {
        $canonical = $request->url();
        $image = $ogImageUrl ?? $this->defaultOgImage();

        return $this->pack($title, $description, $keywords, $canonical, $image, $ogType, $jsonLd, $request);
    }

    /**
     * @param  list<array<string, mixed>>  $jsonLd
     * @return array<string, mixed>
     */
    protected function pack(string $title, ?string $description, ?string $keywords, string $canonical, ?string $ogImage, string $ogType, array $jsonLd, Request $request): array
    {
        $siteName = config('app.name', 'Darpon');
        $description = $description ? Str::limit(strip_tags($description), (int) config('seo.max_meta_description_length', 320), '') : null;
        $ogDescription = $description ? Str::limit($description, (int) config('seo.max_og_description_length', 300), '') : null;

        return [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'canonical_url' => $canonical,
            'og_title' => $title,
            'og_description' => $ogDescription,
            'og_image' => $ogImage,
            'og_url' => $canonical,
            'og_type' => $ogType,
            'og_site_name' => $siteName,
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $title,
            'twitter_description' => $ogDescription,
            'twitter_image' => $ogImage,
            'json_ld' => array_values(array_filter($jsonLd)),
        ];
    }

    protected function nonEmpty(?string $value): ?string
    {
        $v = $value !== null ? trim($value) : '';

        return $v !== '' ? $value : null;
    }

    protected function plainExcerpt(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return null;
        }

        $text = preg_replace('/\s+/', ' ', strip_tags($html)) ?? '';

        return Str::limit(trim($text), (int) config('seo.max_meta_description_length', 320), '');
    }

    /**
     * @param  mixed  $options
     */
    protected function keywordsFromArray($options): ?string
    {
        if (!is_array($options) || $options === []) {
            return null;
        }

        $flat = array_filter(array_map('strval', $options), fn (string $s) => trim($s) !== '');

        return $flat !== [] ? implode(', ', $flat) : null;
    }

    protected function absoluteImage(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return url(Storage::disk('public')->url($path));
    }

    protected function defaultOgImage(): string
    {
        $fromSetting = $this->absoluteImage($this->setting('seo_og_image'));
        if ($fromSetting) {
            return $fromSetting;
        }

        $path = config('seo.default_image', '/darponbdv.png');

        return str_starts_with($path, 'http') ? $path : url($path);
    }

    protected function setting(string $key, ?string $default = null): ?string
    {
        try {
            return Setting::get($key, $default);
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function webSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => config('app.name', 'Darpon'),
            'url' => route('home', absolute: true),
        ];
    }

    /**
     * @param  list<array{name: string, url: string}>  $items
     * @return array<string, mixed>
     */
    protected function breadcrumbSchema(array $items): array
    {
        $elements = [];
        foreach ($items as $i => $item) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $elements,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function bookSchema(Book $book, string $url, ?string $description, ?string $image): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Book',
            'name' => $book->title,
            'url' => $url,
        ];
        if ($this->nonEmpty($book->author)) {
            $schema['author'] = [
                '@type' => 'Person',
                'name' => $book->author,
            ];
        }
        if ($description) {
            $schema['description'] = $description;
        }
        if ($image) {
            $schema['image'] = $image;
        }
        if ($book->price !== null) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => (string) $book->price,
                'priceCurrency' => 'BDT',
                'availability' => $book->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ];
        }

        return $schema;
    }

    /**
     * @return array<string, mixed>
     */
    protected function courseSchema(Course $course, string $url, ?string $description, ?string $image): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $course->title,
            'url' => $url,
            'provider' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'Darpon'),
                'sameAs' => route('home', absolute: true),
            ],
        ];
        if ($description) {
            $schema['description'] = $description;
        }
        if ($image) {
            $schema['image'] = $image;
        }

        return $schema;
    }

    /**
     * @return array<string, mixed>
     */
    protected function personSchema(Teacher $teacher, string $url, ?string $description, ?string $image): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $teacher->name,
            'url' => $url,
            'jobTitle' => $teacher->designation,
            'worksFor' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'Darpon'),
            ],
        ];
        if ($description) {
            $schema['description'] = $description;
        }
        if ($image) {
            $schema['image'] = $image;
        }

        return $schema;
    }
}
