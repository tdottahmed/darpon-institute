<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Course::create([
            'title' => 'Laravel for Beginners',
            'slug' => 'laravel-for-beginners',
            'short_description' => 'Learn Laravel from scratch.',
            'tags' => ['php', 'laravel', 'backend'],
            'long_description' => 'This is a comprehensive course on Laravel...',
            'duration' => '5h 30m',
            'status' => true,
        ]);

        \App\Models\Course::create([
            'title' => 'React Mastery',
            'slug' => 'react-mastery',
            'short_description' => 'Master React JS development.',
            'tags' => ['javascript', 'react', 'frontend'],
            'long_description' => 'Become a pro React developer...',
            'duration' => '8h 15m',
            'status' => true,
        ]);
    }
}
