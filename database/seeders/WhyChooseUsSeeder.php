<?php

namespace Database\Seeders;

use App\Models\FrontendContent;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['key' => 'section_badge',    'type' => 'text',     'en' => 'Why Choose Us',                                                          'bn' => 'কেন আমাদের বেছে নেবেন'],
            ['key' => 'section_title',    'type' => 'text',     'en' => 'The Best Place to Learn English',                                         'bn' => 'ইংরেজি শেখার সেরা জায়গা'],
            ['key' => 'section_subtitle', 'type' => 'textarea', 'en' => 'We combine expert teaching, modern methods and a supportive community to help you achieve real English fluency.', 'bn' => 'আমরা বিশেষজ্ঞ শিক্ষণ, আধুনিক পদ্ধতি এবং সহায়ক সম্প্রদায়কে একত্রিত করি।'],
            ['key' => 'btn_free_class_label', 'type' => 'text', 'en' => 'Join Our Free Class',                                                     'bn' => 'ফ্রি ক্লাসে যোগ দিন'],
            ['key' => 'modal_title',      'type' => 'text',     'en' => 'Register for a Free Class',                                               'bn' => 'ফ্রি ক্লাসের জন্য নিবন্ধন করুন'],
            ['key' => 'modal_subtitle',   'type' => 'textarea', 'en' => 'Fill in your details below and we\'ll reach out to schedule your free class.',  'bn' => 'আপনার তথ্য পূরণ করুন, আমরা আপনার ফ্রি ক্লাসের সময়সূচি নিশ্চিত করতে যোগাযোগ করব।'],
            // Feature 1
            ['key' => 'feature_1_icon',        'type' => 'text',     'en' => '🎯', 'bn' => '🎯'],
            ['key' => 'feature_1_title',       'type' => 'text',     'en' => 'Expert Instructors',                                                              'bn' => 'বিশেষজ্ঞ প্রশিক্ষক'],
            ['key' => 'feature_1_description', 'type' => 'textarea', 'en' => 'Learn from certified teachers with 10+ years of experience in English language education.', 'bn' => 'ইংরেজি ভাষা শিক্ষায় ১০+ বছরের অভিজ্ঞতাসম্পন্ন শিক্ষকদের কাছ থেকে শিখুন।'],
            // Feature 2
            ['key' => 'feature_2_icon',        'type' => 'text',     'en' => '📚', 'bn' => '📚'],
            ['key' => 'feature_2_title',       'type' => 'text',     'en' => 'Comprehensive Curriculum',                                                        'bn' => 'ব্যাপক পাঠ্যক্রম'],
            ['key' => 'feature_2_description', 'type' => 'textarea', 'en' => 'Structured lessons covering speaking, writing, listening and reading skills.',     'bn' => 'কথা বলা, লেখা, শোনা ও পড়ার দক্ষতা কভার করে কাঠামোবদ্ধ পাঠ।'],
            // Feature 3
            ['key' => 'feature_3_icon',        'type' => 'text',     'en' => '🏆', 'bn' => '🏆'],
            ['key' => 'feature_3_title',       'type' => 'text',     'en' => 'Certified Courses',                                                               'bn' => 'সার্টিফাইড কোর্স'],
            ['key' => 'feature_3_description', 'type' => 'textarea', 'en' => 'Earn industry-recognized certificates upon completing your courses.',              'bn' => 'কোর্স সম্পন্ন করার পর শিল্প-স্বীকৃত সার্টিফিকেট অর্জন করুন।'],
            // Feature 4
            ['key' => 'feature_4_icon',        'type' => 'text',     'en' => '💬', 'bn' => '💬'],
            ['key' => 'feature_4_title',       'type' => 'text',     'en' => 'Interactive Learning',                                                            'bn' => 'ইন্টারেক্টিভ লার্নিং'],
            ['key' => 'feature_4_description', 'type' => 'textarea', 'en' => 'Live sessions, group discussions and real-world English practice.',                'bn' => 'লাইভ সেশন, গ্রুপ আলোচনা এবং বাস্তব জীবনের ইংরেজি অনুশীলন।'],
            // Feature 5
            ['key' => 'feature_5_icon',        'type' => 'text',     'en' => '📱', 'bn' => '📱'],
            ['key' => 'feature_5_title',       'type' => 'text',     'en' => 'Learn Anywhere',                                                                  'bn' => 'যেকোনো জায়গা থেকে শিখুন'],
            ['key' => 'feature_5_description', 'type' => 'textarea', 'en' => 'Access all course materials on any device, anytime you want.',                    'bn' => 'যেকোনো ডিভাইসে, যেকোনো সময় সমস্ত কোর্স উপকরণ অ্যাক্সেস করুন।'],
            // Feature 6
            ['key' => 'feature_6_icon',        'type' => 'text',     'en' => '🌟', 'bn' => '🌟'],
            ['key' => 'feature_6_title',       'type' => 'text',     'en' => 'Proven Results',                                                                  'bn' => 'প্রমাণিত ফলাফল'],
            ['key' => 'feature_6_description', 'type' => 'textarea', 'en' => 'Over 5000+ students have transformed their English communication skills with us.', 'bn' => '৫০০০+ এর বেশি শিক্ষার্থী আমাদের সাথে তাদের ইংরেজি দক্ষতা রূপান্তরিত করেছে।'],
        ];

        foreach ($rows as $row) {
            FrontendContent::updateOrCreate(
                ['section' => 'why_choose_us', 'key' => $row['key']],
                ['value' => ['en' => $row['en'], 'bn' => $row['bn']], 'type' => $row['type']],
            );
        }
    }
}
