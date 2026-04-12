<?php

namespace App\Services;

use App\Models\VideoBlog;
use App\Models\Course;
use App\Models\Book;
use Illuminate\Support\Collection;

class FeedService
{
    /**
     * Get all feed items combined from VideoBlogs, Courses, and Books.
     *
     * @return Collection
     */
    public static function getAllFeedItems(): Collection
    {
        $videoBlogs = class_exists(VideoBlog::class) ? VideoBlog::getFeedItems() : collect();
        $courses = class_exists(Course::class) ? Course::getFeedItems() : collect();
        $books = class_exists(Book::class) ? Book::getFeedItems() : collect();

        // Merge all into a single collection and sort by latest updated
        return $videoBlogs
            ->merge($courses)
            ->merge($books)
            ->sortByDesc('updated_at')
            ->values();
    }
}
