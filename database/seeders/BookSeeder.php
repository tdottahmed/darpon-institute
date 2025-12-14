<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Art of Learning',
                'author' => 'Josh Waitzkin',
                'short_description' => '<p>A powerful guide to mastering any skill through deliberate practice and mental models.</p>',
                'long_description' => '<p>In this inspiring book, Josh Waitzkin shares his journey from chess prodigy to martial arts champion, revealing the principles that helped him excel in multiple disciplines. You will learn:</p><ul><li>How to develop deep focus and concentration</li><li>Techniques for breaking down complex skills</li><li>Building resilience and learning from mistakes</li><li>Creating effective practice routines</li><li>Mental models for accelerated learning</li></ul><p>Perfect for anyone looking to improve their learning abilities and achieve mastery in their chosen field.</p>',
                'tags' => ['learning', 'self-improvement', 'productivity', 'education'],
                'price' => 24.99,
                'discount' => 10,
                'stock_quantity' => 50,
                'status' => true,
            ],
            [
                'title' => 'Business Strategy Essentials',
                'author' => 'Michael Porter',
                'short_description' => '<p>Comprehensive guide to developing winning business strategies in competitive markets.</p>',
                'long_description' => '<p>Master the fundamentals of business strategy with this comprehensive guide. Topics include:</p><ul><li>Competitive analysis and market positioning</li><li>Value chain optimization</li><li>Strategic planning frameworks</li><li>Market entry strategies</li><li>Long-term competitive advantage</li></ul><p>Essential reading for entrepreneurs, managers, and business students.</p>',
                'tags' => ['business', 'strategy', 'management', 'entrepreneurship'],
                'price' => 29.99,
                'discount' => 0,
                'stock_quantity' => 75,
                'status' => true,
            ],
            [
                'title' => 'Creative Writing Mastery',
                'author' => 'Stephen King',
                'short_description' => '<p>Learn the craft of writing from one of the most successful authors of our time.</p>',
                'long_description' => '<p>Discover the secrets of compelling storytelling and effective writing. This book covers:</p><ul><li>Character development and dialogue</li><li>Plot structure and pacing</li><li>Writing techniques and style</li><li>Overcoming writer\'s block</li><li>Editing and revision strategies</li></ul><p>Ideal for aspiring writers and anyone interested in improving their writing skills.</p>',
                'tags' => ['writing', 'creativity', 'literature', 'storytelling'],
                'price' => 19.99,
                'discount' => 15,
                'stock_quantity' => 30,
                'status' => true,
            ],
            [
                'title' => 'Digital Marketing Fundamentals',
                'author' => 'David Meerman Scott',
                'short_description' => '<p>Complete guide to modern digital marketing strategies and tactics.</p>',
                'long_description' => '<p>Master digital marketing with this comprehensive resource. Learn about:</p><ul><li>Social media marketing strategies</li><li>Content marketing and SEO</li><li>Email marketing campaigns</li><li>Analytics and measurement</li><li>Marketing automation tools</li></ul><p>Perfect for marketers, business owners, and marketing students.</p>',
                'tags' => ['marketing', 'digital', 'social media', 'business'],
                'price' => 27.99,
                'discount' => 5,
                'stock_quantity' => 100,
                'status' => true,
            ],
            [
                'title' => 'Mindful Living Guide',
                'author' => 'Thich Nhat Hanh',
                'short_description' => '<p>Practical wisdom for living with mindfulness and inner peace in daily life.</p>',
                'long_description' => '<p>Transform your life through the practice of mindfulness. This guide teaches:</p><ul><li>Meditation techniques and practices</li><li>Mindful breathing exercises</li><li>Living in the present moment</li><li>Reducing stress and anxiety</li><li>Cultivating compassion and kindness</li></ul><p>Ideal for anyone seeking peace, clarity, and fulfillment in their daily life.</p>',
                'tags' => ['mindfulness', 'meditation', 'self-help', 'wellness'],
                'price' => 16.99,
                'discount' => 20,
                'stock_quantity' => 60,
                'status' => true,
            ],
            [
                'title' => 'Financial Planning Basics',
                'author' => 'Robert Kiyosaki',
                'short_description' => '<p>Essential principles for building wealth and achieving financial independence.</p>',
                'long_description' => '<p>Learn the fundamentals of personal finance and wealth building. Topics include:</p><ul><li>Budgeting and expense management</li><li>Investment strategies</li><li>Debt management</li><li>Retirement planning</li><li>Building passive income streams</li></ul><p>Essential reading for anyone looking to improve their financial situation.</p>',
                'tags' => ['finance', 'money', 'investing', 'personal development'],
                'price' => 22.99,
                'discount' => 0,
                'stock_quantity' => 45,
                'status' => true,
            ],
            [
                'title' => 'Leadership Principles',
                'author' => 'John C. Maxwell',
                'short_description' => '<p>Timeless principles for becoming an effective and inspiring leader.</p>',
                'long_description' => '<p>Develop your leadership skills with proven principles and practices. This book covers:</p><ul><li>Building trust and credibility</li><li>Effective communication skills</li><li>Team building and motivation</li><li>Decision-making frameworks</li><li>Leading through change</li></ul><p>Perfect for managers, team leaders, and aspiring executives.</p>',
                'tags' => ['leadership', 'management', 'business', 'professional'],
                'price' => 26.99,
                'discount' => 12,
                'stock_quantity' => 80,
                'status' => true,
            ],
            [
                'title' => 'Healthy Cooking Made Simple',
                'author' => 'Jamie Oliver',
                'short_description' => '<p>Delicious and nutritious recipes for everyday cooking at home.</p>',
                'long_description' => '<p>Discover easy-to-follow recipes for healthy, delicious meals. This cookbook includes:</p><ul><li>Quick and easy recipes</li><li>Nutritional information</li><li>Cooking tips and techniques</li><li>Meal planning ideas</li><li>Budget-friendly options</li></ul><p>Perfect for home cooks looking to eat healthier without sacrificing flavor.</p>',
                'tags' => ['cooking', 'health', 'recipes', 'food'],
                'price' => 18.99,
                'discount' => 8,
                'stock_quantity' => 25,
                'status' => true,
            ],
        ];

        foreach ($books as $bookData) {
            Book::create([
                'title' => $bookData['title'],
                'slug' => Str::slug($bookData['title']),
                'author' => $bookData['author'],
                'short_description' => $bookData['short_description'],
                'long_description' => $bookData['long_description'],
                'tags' => $bookData['tags'],
                'price' => $bookData['price'],
                'discount' => $bookData['discount'],
                'stock_quantity' => $bookData['stock_quantity'],
                'status' => $bookData['status'],
            ]);
        }
    }
}
