<?php

namespace Database\Seeders;

use App\Models\FrontendContent;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // ── Header menu ──────────────────────────────────────────────────
            ['key' => 'menu_why_choose_us', 'type' => 'text', 'section' => 'header',
                'en' => 'Why Choose Us', 'bn' => 'কেন আমাদের বেছে নেবেন'],

            // ── Homepage section ─────────────────────────────────────────────
            ['key' => 'section_badge',        'type' => 'text',     'en' => 'Why Choose Us',                  'bn' => 'কেন আমাদের বেছে নেবেন'],
            ['key' => 'section_title',        'type' => 'text',     'en' => 'The Best Place to Learn English', 'bn' => 'ইংরেজি শেখার সেরা জায়গা'],
            ['key' => 'section_subtitle',     'type' => 'textarea', 'en' => 'We combine expert teaching, modern methods and a supportive community to help you achieve real English fluency.', 'bn' => 'আমরা বিশেষজ্ঞ শিক্ষণ, আধুনিক পদ্ধতি এবং সহায়ক সম্প্রদায়কে একত্রিত করি।'],
            ['key' => 'btn_free_class_label', 'type' => 'text',     'en' => 'Join Our Free Class',             'bn' => 'ফ্রি ক্লাসে যোগ দিন'],
            ['key' => 'modal_title',          'type' => 'text',     'en' => 'Register for a Free Class',       'bn' => 'ফ্রি ক্লাসের জন্য নিবন্ধন করুন'],
            ['key' => 'modal_subtitle',       'type' => 'textarea', 'en' => 'Fill in your details and we\'ll reach out to schedule your free class.', 'bn' => 'আপনার তথ্য পূরণ করুন, আমরা যোগাযোগ করব।'],

            // ── 6 features ───────────────────────────────────────────────────
            ['key' => 'feature_1_icon',        'type' => 'text',     'en' => '🎯', 'bn' => '🎯'],
            ['key' => 'feature_1_title',       'type' => 'text',     'en' => 'Expert Instructors',         'bn' => 'বিশেষজ্ঞ প্রশিক্ষক'],
            ['key' => 'feature_1_description', 'type' => 'textarea', 'en' => 'Learn from certified teachers with 10+ years of proven experience in English education.', 'bn' => 'ইংরেজি ভাষা শিক্ষায় ১০+ বছরের অভিজ্ঞতাসম্পন্ন শিক্ষকদের কাছ থেকে শিখুন।'],
            ['key' => 'feature_2_icon',        'type' => 'text',     'en' => '📚', 'bn' => '📚'],
            ['key' => 'feature_2_title',       'type' => 'text',     'en' => 'Comprehensive Curriculum',   'bn' => 'ব্যাপক পাঠ্যক্রম'],
            ['key' => 'feature_2_description', 'type' => 'textarea', 'en' => 'Structured lessons covering speaking, writing, listening and reading from beginner to advanced.', 'bn' => 'কথা বলা, লেখা, শোনা ও পড়ার দক্ষতা কভার করে কাঠামোবদ্ধ পাঠ।'],
            ['key' => 'feature_3_icon',        'type' => 'text',     'en' => '🏆', 'bn' => '🏆'],
            ['key' => 'feature_3_title',       'type' => 'text',     'en' => 'Certified Courses',          'bn' => 'সার্টিফাইড কোর্স'],
            ['key' => 'feature_3_description', 'type' => 'textarea', 'en' => 'Earn industry-recognized certificates that open doors in careers and higher education.', 'bn' => 'কোর্স সম্পন্ন করার পর শিল্প-স্বীকৃত সার্টিফিকেট অর্জন করুন।'],
            ['key' => 'feature_4_icon',        'type' => 'text',     'en' => '💬', 'bn' => '💬'],
            ['key' => 'feature_4_title',       'type' => 'text',     'en' => 'Interactive Learning',       'bn' => 'ইন্টারেক্টিভ লার্নিং'],
            ['key' => 'feature_4_description', 'type' => 'textarea', 'en' => 'Live sessions, group discussions and real-world practice scenarios that build true fluency.', 'bn' => 'লাইভ সেশন, গ্রুপ আলোচনা এবং বাস্তব জীবনের ইংরেজি অনুশীলন।'],
            ['key' => 'feature_5_icon',        'type' => 'text',     'en' => '📱', 'bn' => '📱'],
            ['key' => 'feature_5_title',       'type' => 'text',     'en' => 'Learn Anywhere',             'bn' => 'যেকোনো জায়গা থেকে শিখুন'],
            ['key' => 'feature_5_description', 'type' => 'textarea', 'en' => 'Access all course materials on any device — phone, tablet or computer — anytime you want.', 'bn' => 'যেকোনো ডিভাইসে, যেকোনো সময় সমস্ত কোর্স উপকরণ অ্যাক্সেস করুন।'],
            ['key' => 'feature_6_icon',        'type' => 'text',     'en' => '🌟', 'bn' => '🌟'],
            ['key' => 'feature_6_title',       'type' => 'text',     'en' => 'Proven Results',             'bn' => 'প্রমাণিত ফলাফল'],
            ['key' => 'feature_6_description', 'type' => 'textarea', 'en' => 'Over 5000+ students have transformed their English communication skills with us.', 'bn' => '৫০০০+ এর বেশি শিক্ষার্থী আমাদের সাথে তাদের ইংরেজি দক্ষতা রূপান্তরিত করেছে।'],

            // ── Dedicated page hero ──────────────────────────────────────────
            ['key' => 'page_hero_title',    'type' => 'text',     'en' => 'Why Thousands Choose Darpon', 'bn' => 'কেন হাজার হাজার শিক্ষার্থী দারপন বেছে নেন'],
            ['key' => 'page_hero_subtitle', 'type' => 'textarea', 'en' => 'From absolute beginners to advanced professionals — we\'ve helped over 5,000 students unlock real English fluency through expert teaching, structured learning and genuine care.', 'bn' => 'একদম শুরু থেকে উন্নত পেশাদার পর্যন্ত — আমরা ৫,০০০+ শিক্ষার্থীকে বিশেষজ্ঞ শিক্ষা এবং সুনির্দিষ্ট পরিকল্পনার মাধ্যমে প্রকৃত ইংরেজি দক্ষতা অর্জনে সাহায্য করেছি।'],

            // ── Page stats ───────────────────────────────────────────────────
            ['key' => 'page_stat_1_value', 'type' => 'text', 'en' => '5000+', 'bn' => '৫০০০+'],
            ['key' => 'page_stat_1_label', 'type' => 'text', 'en' => 'Students Taught',     'bn' => 'শিক্ষার্থী'],
            ['key' => 'page_stat_2_value', 'type' => 'text', 'en' => '10+',   'bn' => '১০+'],
            ['key' => 'page_stat_2_label', 'type' => 'text', 'en' => 'Years of Excellence', 'bn' => 'বছরের অভিজ্ঞতা'],
            ['key' => 'page_stat_3_value', 'type' => 'text', 'en' => '98%',   'bn' => '৯৮%'],
            ['key' => 'page_stat_3_label', 'type' => 'text', 'en' => 'Student Success Rate','bn' => 'সাফল্যের হার'],
            ['key' => 'page_stat_4_value', 'type' => 'text', 'en' => '50+',   'bn' => '৫০+'],
            ['key' => 'page_stat_4_label', 'type' => 'text', 'en' => 'Expert Courses',      'bn' => 'বিশেষজ্ঞ কোর্স'],

            // ── Methodology ──────────────────────────────────────────────────
            ['key' => 'method_badge',    'type' => 'text',     'en' => 'Our Approach',  'bn' => 'আমাদের পদ্ধতি'],
            ['key' => 'method_title',    'type' => 'text',     'en' => 'A Proven 4-Step Learning System', 'bn' => 'প্রমাণিত ৪-ধাপের শিক্ষা পদ্ধতি'],
            ['key' => 'method_subtitle', 'type' => 'textarea', 'en' => 'Every student follows our structured pathway designed to build real, lasting English proficiency.', 'bn' => 'প্রতিটি শিক্ষার্থী আমাদের কাঠামোবদ্ধ পথ অনুসরণ করে যা প্রকৃত ইংরেজি দক্ষতা তৈরি করে।'],

            ['key' => 'step_1_icon', 'type' => 'text', 'en' => '🔍', 'bn' => '🔍'],
            ['key' => 'step_1_title', 'type' => 'text', 'en' => 'Assess Your Level', 'bn' => 'আপনার স্তর মূল্যায়ন'],
            ['key' => 'step_1_description', 'type' => 'textarea', 'en' => 'We evaluate your current English skills through a comprehensive test to understand exactly where you are.', 'bn' => 'আমরা আপনার বর্তমান ইংরেজি দক্ষতা একটি ব্যাপক পরীক্ষার মাধ্যমে মূল্যায়ন করি।'],

            ['key' => 'step_2_icon', 'type' => 'text', 'en' => '🗺️', 'bn' => '🗺️'],
            ['key' => 'step_2_title', 'type' => 'text', 'en' => 'Personalized Learning Plan', 'bn' => 'ব্যক্তিগতকৃত শিক্ষা পরিকল্পনা'],
            ['key' => 'step_2_description', 'type' => 'textarea', 'en' => 'Based on your results, we craft a custom curriculum aligned to your goals — career, exam, or daily use.', 'bn' => 'ফলাফলের ভিত্তিতে আপনার লক্ষ্য অনুযায়ী একটি কাস্টম পাঠ্যক্রম তৈরি করা হয়।'],

            ['key' => 'step_3_icon', 'type' => 'text', 'en' => '💪', 'bn' => '💪'],
            ['key' => 'step_3_title', 'type' => 'text', 'en' => 'Active Daily Practice', 'bn' => 'সক্রিয় দৈনিক অনুশীলন'],
            ['key' => 'step_3_description', 'type' => 'textarea', 'en' => 'Engage in structured exercises, live speaking sessions and interactive lessons that accelerate progress.', 'bn' => 'কাঠামোবদ্ধ অনুশীলন, লাইভ স্পিকিং সেশন এবং ইন্টারেক্টিভ পাঠে অংশগ্রহণ করুন।'],

            ['key' => 'step_4_icon', 'type' => 'text', 'en' => '🎓', 'bn' => '🎓'],
            ['key' => 'step_4_title', 'type' => 'text', 'en' => 'Achieve & Get Certified', 'bn' => 'অর্জন করুন এবং সার্টিফাইড হন'],
            ['key' => 'step_4_description', 'type' => 'textarea', 'en' => 'Complete your course, receive a recognized certificate and step into the world with real English confidence.', 'bn' => 'কোর্স সম্পন্ন করুন, স্বীকৃত সার্টিফিকেট পান এবং প্রকৃত ইংরেজি আত্মবিশ্বাস নিয়ে এগিয়ে যান।'],

            // ── Outcomes ─────────────────────────────────────────────────────
            ['key' => 'outcome_badge',    'type' => 'text',     'en' => 'Student Results',              'bn' => 'শিক্ষার্থীর ফলাফল'],
            ['key' => 'outcome_title',    'type' => 'text',     'en' => 'What Our Students Achieve',    'bn' => 'আমাদের শিক্ষার্থীরা যা অর্জন করে'],
            ['key' => 'outcome_subtitle', 'type' => 'textarea', 'en' => 'These are the real, measurable results our graduates walk away with — not promises, but proven outcomes.', 'bn' => 'এগুলো আমাদের শিক্ষার্থীদের প্রকৃত, পরিমাপযোগ্য ফলাফল।'],

            ['key' => 'outcome_1_text', 'type' => 'text', 'en' => 'Speak confidently in meetings & interviews',   'bn' => 'মিটিং ও ইন্টারভিউতে আত্মবিশ্বাসের সাথে কথা বলুন'],
            ['key' => 'outcome_2_text', 'type' => 'text', 'en' => 'Write professional emails & reports',          'bn' => 'পেশাদার ইমেইল ও রিপোর্ট লিখুন'],
            ['key' => 'outcome_3_text', 'type' => 'text', 'en' => 'Pass IELTS / TOEFL with high scores',          'bn' => 'আইইএলটিএস/টোয়েফলে উচ্চ স্কোর পান'],
            ['key' => 'outcome_4_text', 'type' => 'text', 'en' => 'Communicate with native speakers fluently',    'bn' => 'নেটিভ স্পিকারদের সাথে সাবলীলভাবে কথা বলুন'],
            ['key' => 'outcome_5_text', 'type' => 'text', 'en' => 'Watch English media without subtitles',        'bn' => 'সাবটাইটেল ছাড়া ইংরেজি মিডিয়া দেখুন'],
            ['key' => 'outcome_6_text', 'type' => 'text', 'en' => 'Build an extensive vocabulary rapidly',        'bn' => 'দ্রুত ব্যাপক শব্দভাণ্ডার তৈরি করুন'],
            ['key' => 'outcome_7_text', 'type' => 'text', 'en' => 'Master professional English pronunciation',    'bn' => 'পেশাদার ইংরেজি উচ্চারণ আয়ত্ত করুন'],
            ['key' => 'outcome_8_text', 'type' => 'text', 'en' => 'Use English naturally in everyday life',       'bn' => 'দৈনন্দিন জীবনে স্বাভাবিকভাবে ইংরেজি ব্যবহার করুন'],

            // ── Testimonial pull-quote ────────────────────────────────────────
            ['key' => 'testimonial_quote',  'type' => 'textarea', 'en' => 'I spent years afraid to speak English in public. After just 3 months at Darpon, I gave a presentation in front of 50 colleagues — in English — and got a standing ovation.', 'bn' => 'আমি বছরের পর বছর প্রকাশ্যে ইংরেজিতে কথা বলতে ভয় পেতাম। দারপনে মাত্র ৩ মাস পরে, আমি ৫০ জন সহকর্মীর সামনে ইংরেজিতে উপস্থাপনা করলাম।'],
            ['key' => 'testimonial_author', 'type' => 'text',     'en' => 'Farhan A., Software Engineer', 'bn' => 'ফারহান এ., সফটওয়্যার ইঞ্জিনিয়ার'],

            // ── Differentiators ───────────────────────────────────────────────
            ['key' => 'diff_badge',    'type' => 'text',     'en' => 'What Sets Us Apart', 'bn' => 'আমরা কীভাবে আলাদা'],
            ['key' => 'diff_title',    'type' => 'text',     'en' => 'We Do Things Differently', 'bn' => 'আমরা ভিন্নভাবে কাজ করি'],
            ['key' => 'diff_subtitle', 'type' => 'textarea', 'en' => 'Most English courses teach grammar rules. We teach you to think, feel and communicate in English — naturally and confidently.', 'bn' => 'বেশিরভাগ ইংরেজি কোর্স ব্যাকরণের নিয়ম শেখায়। আমরা আপনাকে ইংরেজিতে চিন্তা করতে, অনুভব করতে এবং যোগাযোগ করতে শেখাই।'],

            ['key' => 'diff_1_icon',        'type' => 'text',     'en' => '🎯', 'bn' => '🎯'],
            ['key' => 'diff_1_title',       'type' => 'text',     'en' => 'Hyper-personalized Learning', 'bn' => 'ব্যক্তিগতকৃত শিক্ষা'],
            ['key' => 'diff_1_description', 'type' => 'textarea', 'en' => 'Unlike generic classrooms that teach everyone the same way, we build a unique roadmap for every student\'s goals, pace, and learning style.', 'bn' => 'সাধারণ শ্রেণিকক্ষের বিপরীতে, আমরা প্রতিটি শিক্ষার্থীর লক্ষ্য, গতি এবং শেখার ধরন অনুযায়ী একটি অনন্য রোডম্যাপ তৈরি করি।'],
            ['key' => 'diff_1_point_1',     'type' => 'text', 'en' => 'Individual skill gap analysis',    'bn' => 'ব্যক্তিগত দক্ষতার ফাঁক বিশ্লেষণ'],
            ['key' => 'diff_1_point_2',     'type' => 'text', 'en' => 'Custom homework & exercises',       'bn' => 'কাস্টম হোমওয়ার্ক ও অনুশীলন'],
            ['key' => 'diff_1_point_3',     'type' => 'text', 'en' => 'Progress tracked every week',       'bn' => 'প্রতি সপ্তাহে অগ্রগতি ট্র্যাক'],

            ['key' => 'diff_2_icon',        'type' => 'text',     'en' => '🌐', 'bn' => '🌐'],
            ['key' => 'diff_2_title',       'type' => 'text',     'en' => 'Real-world English Focus',     'bn' => 'বাস্তব জগতের ইংরেজি'],
            ['key' => 'diff_2_description', 'type' => 'textarea', 'en' => 'Every lesson is built around real communication situations — not textbook grammar. You learn the English people actually use.', 'bn' => 'প্রতিটি পাঠ বাস্তব যোগাযোগের পরিস্থিতির চারপাশে তৈরি — পাঠ্যপুস্তকের ব্যাকরণ নয়।'],
            ['key' => 'diff_2_point_1',     'type' => 'text', 'en' => 'Business & professional scenarios', 'bn' => 'ব্যবসায়িক ও পেশাদার পরিস্থিতি'],
            ['key' => 'diff_2_point_2',     'type' => 'text', 'en' => 'Social conversation practice',      'bn' => 'সামাজিক কথোপকথন অনুশীলন'],
            ['key' => 'diff_2_point_3',     'type' => 'text', 'en' => 'Media, culture & idioms',           'bn' => 'মিডিয়া, সংস্কৃতি ও মুহাবরা'],

            ['key' => 'diff_3_icon',        'type' => 'text',     'en' => '🤝', 'bn' => '🤝'],
            ['key' => 'diff_3_title',       'type' => 'text',     'en' => 'Community & Lifetime Support', 'bn' => 'কমিউনিটি ও আজীবন সহায়তা'],
            ['key' => 'diff_3_description', 'type' => 'textarea', 'en' => 'You\'re never learning alone. Our active community, alumni network and instructor support stay with you long after the course ends.', 'bn' => 'আপনি কখনো একা শিখছেন না। আমাদের সক্রিয় কমিউনিটি, প্রাক্তন শিক্ষার্থী নেটওয়ার্ক এবং প্রশিক্ষক সহায়তা কোর্স শেষেও থাকে।'],
            ['key' => 'diff_3_point_1',     'type' => 'text', 'en' => 'Private student community',          'bn' => 'প্রাইভেট শিক্ষার্থী কমিউনিটি'],
            ['key' => 'diff_3_point_2',     'type' => 'text', 'en' => 'Monthly alumni sessions',            'bn' => 'মাসিক প্রাক্তন শিক্ষার্থী সেশন'],
            ['key' => 'diff_3_point_3',     'type' => 'text', 'en' => 'Dedicated instructor access',        'bn' => 'ডেডিকেটেড প্রশিক্ষক অ্যাক্সেস'],

            // ── Page bottom CTA ───────────────────────────────────────────────
            ['key' => 'page_cta_title',    'type' => 'text',     'en' => 'Ready to Speak English with Confidence?', 'bn' => 'আত্মবিশ্বাসের সাথে ইংরেজি বলতে প্রস্তুত?'],
            ['key' => 'page_cta_subtitle', 'type' => 'textarea', 'en' => 'Join thousands of students who transformed their English skills. Register for a free class today — no commitment required.', 'bn' => 'হাজার হাজার শিক্ষার্থীর সাথে যোগ দিন যারা তাদের ইংরেজি দক্ষতা পরিবর্তন করেছে। আজই একটি বিনামূল্যে ক্লাসের জন্য নিবন্ধন করুন।'],
        ];

        foreach ($rows as $row) {
            $section = $row['section'] ?? 'why_choose_us';
            FrontendContent::updateOrCreate(
                ['section' => $section, 'key' => $row['key']],
                ['value' => ['en' => $row['en'], 'bn' => $row['bn']], 'type' => $row['type']],
            );
        }
    }
}
