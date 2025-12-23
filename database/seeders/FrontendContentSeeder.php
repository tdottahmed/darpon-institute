<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'section' => 'hero',
                'key' => 'welcome_badge',
                'value' => ['en' => '🎓 Start Learning Today', 'bn' => '🎓 আজই শেখা শুরু করুন'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'title_line_1',
                'value' => ['en' => 'Master English', 'bn' => 'ইংরেজি শিখুন'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'title_line_2',
                'value' => ['en' => 'From Anywhere', 'bn' => 'যেকোনো জায়গা থেকে'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'description',
                'value' => ['en' => 'Interactive learning platform with modern methods, digital diplomas, and personalized study plans designed to help you achieve fluency faster.', 'bn' => 'আধুনিক পদ্ধতি, ডিজিটাল ডিপ্লোমা এবং ব্যক্তিগতকৃত স্টাডি প্ল্যান সহ একটি ইন্টারঅ্যাক্টিভ লার্নিং প্ল্যাটফর্ম যা আপনাকে দ্রুত ইংরেজি শিখতে সাহায্য করবে।'],
                'type' => 'textarea',
            ],
            [
                'section' => 'hero',
                'key' => 'bg_image',
                'value' => ['en' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop', 'bn' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1920&auto=format&fit=crop'],
                'type' => 'image',
            ],
            // Stats
            [
                'section' => 'hero',
                'key' => 'stat_1_value',
                'value' => ['en' => '10K+', 'bn' => '১০হাজার+'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_1_label',
                'value' => ['en' => 'Happy Students', 'bn' => 'শিক্ষার্থী'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_2_value',
                'value' => ['en' => '500+', 'bn' => '৫০০+'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_2_label',
                'value' => ['en' => 'Courses', 'bn' => 'কোর্স'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_3_value',
                'value' => ['en' => '4.9', 'bn' => '৪.৯'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_3_label',
                'value' => ['en' => 'User Rating', 'bn' => 'রেটিং'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_4_value',
                'value' => ['en' => '98%', 'bn' => '৯৮%'],
                'type' => 'text',
            ],
            [
                'section' => 'hero',
                'key' => 'stat_4_label',
                'value' => ['en' => 'Success Rate', 'bn' => 'সফলতা'],
                'type' => 'text',
            ],
            // Header
            [
                'section' => 'header',
                'key' => 'menu_home',
                'value' => ['en' => 'Home', 'bn' => 'হোম'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'menu_courses',
                'value' => ['en' => 'Courses', 'bn' => 'কোর্স'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'menu_books',
                'value' => ['en' => 'Books', 'bn' => 'বই'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'menu_about',
                'value' => ['en' => 'About', 'bn' => 'আমাদের সম্পর্কে'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'menu_contact',
                'value' => ['en' => 'Contact', 'bn' => 'যোগাযোগ'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'auth_login',
                'value' => ['en' => 'Log in', 'bn' => 'লগইন'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'auth_register',
                'value' => ['en' => 'Get Started', 'bn' => 'শুরু করুন'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'auth_dashboard',
                'value' => ['en' => 'Dashboard', 'bn' => 'ড্যাশবোর্ড'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'auth_profile',
                'value' => ['en' => 'Profile', 'bn' => 'প্রোফাইল'],
                'type' => 'text',
            ],
            [
                'section' => 'header',
                'key' => 'auth_logout',
                'value' => ['en' => 'Log Out', 'bn' => 'লগ আউট'],
                'type' => 'text',
            ],
            // Features Section
            [
                'section' => 'features',
                'key' => 'header_badge',
                'value' => ['en' => 'Features', 'bn' => 'বৈশিষ্ট্য'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'header_title',
                'value' => ['en' => 'Why Choose Our Platform', 'bn' => 'কেন আমাদের প্ল্যাটফর্ম বেছে নেবেন'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'header_subtitle',
                'value' => ['en' => 'Everything you need to master English in one place', 'bn' => 'ইংরেজি আয়ত্ত করার জন্য আপনার যা কিছু প্রয়োজন, সব এক জায়গায়'],
                'type' => 'text',
            ],
            // Feature 1
            [
                'section' => 'features',
                'key' => 'feature_1_title',
                'value' => ['en' => 'Remote Friendly', 'bn' => 'রিমোট ফ্রেন্ডলি'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'feature_1_description',
                'value' => ['en' => 'Explore a new culture from the comfort of your own home', 'bn' => 'ঘরে বসেই নতুন সংস্কৃতি অন্বেষণ করুন'],
                'type' => 'textarea',
            ],
            // Feature 2
            [
                'section' => 'features',
                'key' => 'feature_2_title',
                'value' => ['en' => 'Digital Diploma', 'bn' => 'ডিজিটাল ডিপ্লোমা'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'feature_2_description',
                'value' => ['en' => 'Earn a recognized certificate upon completion', 'bn' => 'শেষ করার পর স্বীকৃত সার্টিফিকেট অর্জন করুন'],
                'type' => 'textarea',
            ],
             // Feature 3
             [
                'section' => 'features',
                'key' => 'feature_3_title',
                'value' => ['en' => 'Private Target', 'bn' => 'ব্যক্তিগত লক্ষ্য'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'feature_3_description',
                'value' => ['en' => 'Custom study plans that track your specific goals', 'bn' => 'কাস্টম স্টাডি প্ল্যান যা আপনার নির্দিষ্ট লক্ষ্য ট্র্যাক করে'],
                'type' => 'textarea',
            ],
            // Feature 4
            [
                'section' => 'features',
                'key' => 'feature_4_title',
                'value' => ['en' => 'Modern Method', 'bn' => 'আধুনিক পদ্ধতি'],
                'type' => 'text',
            ],
            [
                'section' => 'features',
                'key' => 'feature_4_description',
                'value' => ['en' => 'Interactive study methods powered by technology', 'bn' => 'প্রযুক্তিনির্ভর ইন্টারেক্টিভ অধ্যয়নের পদ্ধতি'],
                'type' => 'textarea',
            ],
            // Courses Section
            [
                'section' => 'courses',
                'key' => 'header_title',
                'value' => ['en' => 'Featured Courses', 'bn' => 'জনপ্রিয় কোর্সসমূহ'],
                'type' => 'text',
            ],
            [
                'section' => 'courses',
                'key' => 'header_subtitle',
                'value' => ['en' => 'Discover our most popular English learning courses designed to help you achieve fluency', 'bn' => 'সাবলীল হতে আমাদের জনপ্রিয় ইংরেজি শিক্ষার কোর্সগুলো দেখুন'],
                'type' => 'textarea',
            ],
            [
                'section' => 'courses',
                'key' => 'view_all_btn',
                'value' => ['en' => 'View All Courses', 'bn' => 'সব কোর্স দেখুন'],
                'type' => 'text',
            ],
            // Books Section
            [
                'section' => 'books',
                'key' => 'header_badge',
                'value' => ['en' => 'Our Library', 'bn' => 'আমাদের লাইব্রেরি'],
                'type' => 'text',
            ],
            [
                'section' => 'books',
                'key' => 'header_title_prefix',
                'value' => ['en' => 'Latest', 'bn' => 'নতুন'],
                'type' => 'text',
            ],
            [
                'section' => 'books',
                'key' => 'header_title_highlight',
                'value' => ['en' => 'Books', 'bn' => 'বই'],
                'type' => 'text',
            ],
            [
                'section' => 'books',
                'key' => 'header_subtitle',
                'value' => ['en' => 'Explore our comprehensive collection of English learning resources designed to help you master the language.', 'bn' => 'ভাষা আয়ত্ত করতে আমাদের ইংরেজি শিক্ষার রিসোর্সগুলো দেখুন।'],
                'type' => 'textarea',
            ],
            [
                'section' => 'books',
                'key' => 'view_all_link',
                'value' => ['en' => 'View all books', 'bn' => 'সব বই দেখুন'],
                'type' => 'text',
            ],
            // Testimonials Section
            [
                'section' => 'testimonials',
                'key' => 'header_badge',
                'value' => ['en' => 'Testimonials', 'bn' => 'প্রশংসা'],
                'type' => 'text',
            ],
            [
                'section' => 'testimonials',
                'key' => 'header_title',
                'value' => ['en' => 'What Our Students Say', 'bn' => 'আমাদের শিক্ষার্থীরা যা বলেন'],
                'type' => 'text',
            ],
            [
                'section' => 'testimonials',
                'key' => 'header_subtitle',
                'value' => ['en' => 'Real feedback from real learners', 'bn' => 'শিক্ষার্থীদের আসল মতামত'],
                'type' => 'text',
            ],
            // Blog Section
            [
                'section' => 'blog',
                'key' => 'header_badge',
                'value' => ['en' => 'Latest Updates', 'bn' => 'সর্বশেষ আপডেট'],
                'type' => 'text',
            ],
            [
                'section' => 'blog',
                'key' => 'header_title_prefix',
                'value' => ['en' => 'Video', 'bn' => 'ভিডিও'],
                'type' => 'text',
            ],
            [
                'section' => 'blog',
                'key' => 'header_title_highlight',
                'value' => ['en' => 'Blogs', 'bn' => 'ব্লগ'],
                'type' => 'text',
            ],
            [
                'section' => 'blog',
                'key' => 'header_subtitle',
                'value' => ['en' => 'Watch our latest tutorials, insights, and updates directly from our team.', 'bn' => 'সরাসরি আমাদের টিমের টিউটোরিয়াল এবং আপডেট দেখুন।'],
                'type' => 'textarea',
            ],
            [
                'section' => 'blog',
                'key' => 'view_all_link',
                'value' => ['en' => 'View all videos', 'bn' => 'সব ভিডিও দেখুন'],
                'type' => 'text',
            ],
            // CTA Section
            [
                'section' => 'cta',
                'key' => 'title',
                'value' => ['en' => 'Ready to Start Your English Journey?', 'bn' => 'আপনার ইংরেজি শেখার যাত্রা শুরু করতে প্রস্তুত?'],
                'type' => 'text',
            ],
            [
                'section' => 'cta',
                'key' => 'subtitle',
                'value' => ['en' => 'Join thousands of students already learning with us. Get started today and transform your English skills!', 'bn' => 'আমাদের সাথে হাজার হাজার শিক্ষার্থী শিখছে। আজই শুরু করুন!'],
                'type' => 'textarea',
            ],
            [
                'section' => 'cta',
                'key' => 'btn_primary',
                'value' => ['en' => 'Get Started Free', 'bn' => 'শুরু করুন'],
                'type' => 'text',
            ],
            [
                'section' => 'cta',
                'key' => 'btn_outline',
                'value' => ['en' => 'Log In', 'bn' => 'লগইন'],
                'type' => 'text',
            ],
            // Footer Section
            [
                'section' => 'footer',
                'key' => 'description',
                'value' => ['en' => 'Empowering students with accessible, high-quality English education. Join Darpon and start your learning journey today.', 'bn' => 'সহজলভ্য এবং মানসম্মত ইংরেজি শিক্ষার মাধ্যমে শিক্ষার্থীদের ক্ষমতায়ন। দর্পণের সাথে আজই শিখতে শুরু করুন।'],
                'type' => 'textarea',
            ],
            [
                'section' => 'footer',
                'key' => 'col_1_title',
                'value' => ['en' => 'Learn', 'bn' => 'শিখুন'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'col_2_title',
                'value' => ['en' => 'Company', 'bn' => 'কোম্পানি'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'col_3_title',
                'value' => ['en' => 'Legal & Support', 'bn' => 'আইনি ও সহায়তা'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'copyright',
                'value' => ['en' => 'All rights reserved.', 'bn' => 'সর্বস্বত্ব সংরক্ষিত।'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'link_courses',
                'value' => ['en' => 'All Courses', 'bn' => 'সব কোর্স'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'link_books',
                'value' => ['en' => 'Books Store', 'bn' => 'বইয়ের দোকান'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'link_about',
                'value' => ['en' => 'About Us', 'bn' => 'আমাদের সম্পর্কে'],
                'type' => 'text',
            ],
            [
                'section' => 'footer',
                'key' => 'link_contact',
                'value' => ['en' => 'Contact', 'bn' => 'যোগাযোগ'],
                'type' => 'text',
            ],
        ];

        foreach ($contents as $content) {
            \App\Models\FrontendContent::updateOrCreate(
                ['section' => $content['section'], 'key' => $content['key']],
                $content
            );
        }
    }
}
