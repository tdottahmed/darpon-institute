<?php

namespace Database\Seeders;

use App\Models\VideoBlog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VideoBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. YouTube Video Example
        $title1 = 'Getting Started with Laravel 11';
        VideoBlog::create([
            'title' => $title1,
            'slug' => Str::slug($title1),
            'short_description' => 'Learn the basics of Laravel 11 framework in this comprehensive guide.',
            'long_description' => '<p>In this video, we will explore the <strong>new features</strong> of Laravel 11 and how to set up a new project.</p><p>We cover routing, controllers, and database migrations.</p>',
            'video_type' => 'youtube',
            'video_file' => null,
            'video_url' => 'https://www.youtube.com/watch?v=MHdOaUe-d9Y', // A dummy valid link (Laracast or similar)
            'thumbnail' => null, // Or seed a dummy image if available
            'tags' => ['laravel', 'php', 'tutorial'],
            'status' => true,
        ]);

        // 2. Uploaded Video Example
        $title2 = 'Advanced Eloquent Relationships';
        VideoBlog::create([
            'title' => $title2,
            'slug' => Str::slug($title2),
            'short_description' => 'Deep dive into Eloquent relationships including Polymorphic interactions.',
            'long_description' => '<p>Mastering Eloquent is key to building complex Laravel applications.</p>',
            'video_type' => 'upload',
            'video_file' => null, // We won't simulate a file upload in seeder to avoid missing file errors
            'video_url' => null,
            'thumbnail' => null,
            'tags' => ['eloquent', 'database', 'advanced'],
            'status' => true,
        ]);

        // 3. Another YouTube Video
        $title3 = 'Tailwind CSS Best Practices';
        VideoBlog::create([
            'title' => $title3,
            'slug' => Str::slug($title3),
            'short_description' => 'How to structure your CSS for scalability.',
            'long_description' => '<p>Stop fighting with your CSS. usage utility classes effectively.</p>',
            'video_type' => 'youtube',
            'video_file' => null,
            'video_url' => 'https://www.youtube.com/watch?v=_CXqYeX2c9g',
            'thumbnail' => null,
            'tags' => ['css', 'tailwind', 'design'],
            'status' => false, // Inactive
        ]);

        $this->command->info('Video Blogs seeded successfully.');
    }
}
