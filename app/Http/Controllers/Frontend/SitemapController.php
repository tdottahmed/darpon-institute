<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Course;
use App\Models\CustomPage;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        return SitemapIndex::create()
            ->add(route('sitemap.books', absolute: true))
            ->add(route('sitemap.courses', absolute: true))
            ->add(route('sitemap.pages', absolute: true))
            ->add(route('sitemap.teachers', absolute: true))
            ->toResponse($request);
    }

    public function books(Request $request)
    {
        $sitemap = Sitemap::create();

        foreach (Book::query()->where('status', true)->orderBy('id')->cursor() as $book) {
            $sitemap->add(
                Url::create(route('books.show', $book, absolute: true))
                    ->setLastModificationDate($book->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }

        return $sitemap->toResponse($request);
    }

    public function courses(Request $request)
    {
        $sitemap = Sitemap::create();

        foreach (Course::query()->where('status', true)->orderBy('id')->cursor() as $course) {
            $sitemap->add(
                Url::create(route('courses.show', $course, absolute: true))
                    ->setLastModificationDate($course->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }

        return $sitemap->toResponse($request);
    }

    public function pages(Request $request)
    {
        $sitemap = Sitemap::create();

        $staticUrls = [
            route('home', absolute: true),
            route('courses.index', absolute: true),
            route('books.index', absolute: true),
            route('video_blogs.index', absolute: true),
            route('galleries.index', absolute: true),
            route('instructors.index', absolute: true),
            route('why-choose-us', absolute: true),
            route('about', absolute: true),
            route('contact', absolute: true),
        ];

        foreach ($staticUrls as $url) {
            $sitemap->add(
                Url::create($url)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        }

        foreach (CustomPage::query()->where('is_active', true)->orderBy('id')->cursor() as $page) {
            $sitemap->add(
                Url::create(route('page.show', $page->slug, absolute: true))
                    ->setLastModificationDate($page->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );
        }

        return $sitemap->toResponse($request);
    }

    public function teachers(Request $request)
    {
        $sitemap = Sitemap::create();

        foreach (Teacher::query()->where('is_active', true)->orderBy('id')->cursor() as $teacher) {
            $sitemap->add(
                Url::create(route('instructors.show', $teacher, absolute: true))
                    ->setLastModificationDate($teacher->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.65)
            );
        }

        return $sitemap->toResponse($request);
    }
}
