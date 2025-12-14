<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'role' => 'Software Engineer',
                'review' => 'This platform helped me improve my English skills significantly. The courses are well-structured and easy to follow.',
                'rating' => 5,
                'status' => true,
            ],
            [
                'name' => 'Michael Chen',
                'role' => 'Business Analyst',
                'review' => 'Great content and amazing instructors. I highly recommend this to anyone looking to advance their career.',
                'rating' => 5,
                'status' => true,
            ],
            [
                'name' => 'Emily Davis',
                'role' => 'Student',
                'review' => 'I loved the video blogs and the book recommendations. It made learning English fun and engaging.',
                'rating' => 4,
                'status' => true,
            ],
             [
                'name' => 'David Wilson',
                'role' => 'Marketing Manager',
                'review' => 'The practical examples in the courses were very helpful for my daily work communication.',
                'rating' => 5,
                'status' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
