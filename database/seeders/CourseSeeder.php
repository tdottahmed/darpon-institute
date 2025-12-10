<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'English Grammar Fundamentals',
                'short_description' => '<p>Master the basics of English grammar with comprehensive lessons covering tenses, parts of speech, and sentence structure.</p>',
                'long_description' => '<p>This comprehensive course covers all the fundamental aspects of English grammar. You will learn about:</p><ul><li>Parts of speech (nouns, verbs, adjectives, etc.)</li><li>Verb tenses and their proper usage</li><li>Sentence structure and formation</li><li>Common grammar mistakes and how to avoid them</li><li>Practical exercises and real-world examples</li></ul><p>Perfect for beginners and intermediate learners who want to strengthen their grammar foundation.</p>',
                'tags' => ['grammar', 'beginner', 'fundamentals', 'english'],
                'duration' => '12h 30m',
                'status' => true,
            ],
            [
                'title' => 'Business English Communication',
                'short_description' => '<p>Enhance your professional communication skills with business-focused English lessons, including email writing, presentations, and meetings.</p>',
                'long_description' => '<p>Designed for professionals, this course helps you communicate effectively in business settings. Topics include:</p><ul><li>Professional email writing</li><li>Presentation skills and public speaking</li><li>Meeting participation and negotiation</li><li>Business vocabulary and terminology</li><li>Cross-cultural communication</li></ul><p>Ideal for working professionals and students preparing for business careers.</p>',
                'tags' => ['business', 'professional', 'communication', 'intermediate'],
                'duration' => '15h 45m',
                'status' => true,
            ],
            [
                'title' => 'IELTS Preparation Course',
                'short_description' => '<p>Comprehensive IELTS preparation covering all four sections: Listening, Reading, Writing, and Speaking with practice tests and strategies.</p>',
                'long_description' => '<p>Get ready for your IELTS exam with this complete preparation course. The course includes:</p><ul><li>Detailed coverage of all four IELTS sections</li><li>Test-taking strategies and tips</li><li>Practice tests with detailed feedback</li><li>Time management techniques</li><li>Common mistakes to avoid</li></ul><p>Perfect for students planning to study or work abroad.</p>',
                'tags' => ['ielts', 'exam', 'test preparation', 'advanced'],
                'duration' => '20h 00m',
                'status' => true,
            ],
            [
                'title' => 'Conversational English Mastery',
                'short_description' => '<p>Build confidence in everyday conversations with practical speaking exercises, common phrases, and real-world scenarios.</p>',
                'long_description' => '<p>Improve your speaking skills and confidence with this interactive course. You will learn:</p><ul><li>Common phrases and expressions</li><li>Pronunciation and intonation</li><li>Small talk and social conversations</li><li>Handling different situations (restaurants, shopping, travel)</li><li>Building vocabulary for daily use</li></ul><p>Great for learners who want to feel more comfortable speaking English in daily life.</p>',
                'tags' => ['conversation', 'speaking', 'practical', 'intermediate'],
                'duration' => '10h 20m',
                'status' => true,
            ],
            [
                'title' => 'Academic Writing Excellence',
                'short_description' => '<p>Learn to write academic papers, essays, and research papers with proper structure, citation, and academic style.</p>',
                'long_description' => '<p>Master academic writing with this comprehensive course covering:</p><ul><li>Essay structure and organization</li><li>Research paper writing</li><li>Citation styles (APA, MLA, Chicago)</li><li>Academic vocabulary and formal tone</li><li>Critical thinking and argumentation</li></ul><p>Essential for university students and academic professionals.</p>',
                'tags' => ['academic', 'writing', 'essays', 'advanced'],
                'duration' => '18h 15m',
                'status' => true,
            ],
            [
                'title' => 'English Pronunciation & Accent Training',
                'short_description' => '<p>Perfect your pronunciation and reduce your accent with phonetic training, tongue placement exercises, and listening practice.</p>',
                'long_description' => '<p>Improve your pronunciation and develop a clearer accent with this specialized course. Topics include:</p><ul><li>Phonetic alphabet and sound production</li><li>Tongue placement and mouth positioning</li><li>Stress patterns and intonation</li><li>Common pronunciation challenges</li><li>Practice with native speaker audio</li></ul><p>Ideal for learners who want to sound more natural and be better understood.</p>',
                'tags' => ['pronunciation', 'accent', 'speaking', 'all levels'],
                'duration' => '14h 00m',
                'status' => true,
            ],
            [
                'title' => 'English Vocabulary Builder',
                'short_description' => '<p>Expand your vocabulary systematically with themed lessons, word families, and memory techniques for effective learning.</p>',
                'long_description' => '<p>Build a strong vocabulary foundation with this structured course. You will learn:</p><ul><li>High-frequency words and phrases</li><li>Word families and word formation</li><li>Synonyms, antonyms, and collocations</li><li>Memory techniques and learning strategies</li><li>Themed vocabulary (travel, food, technology, etc.)</li></ul><p>Perfect for learners at any level who want to expand their word knowledge.</p>',
                'tags' => ['vocabulary', 'words', 'learning', 'all levels'],
                'duration' => '16h 30m',
                'status' => true,
            ],
            [
                'title' => 'TOEFL Preparation Complete Guide',
                'short_description' => '<p>Comprehensive TOEFL preparation with strategies for all sections, practice tests, and score improvement techniques.</p>',
                'long_description' => '<p>Prepare for the TOEFL exam with confidence. This course covers:</p><ul><li>All four TOEFL sections in detail</li><li>Test format and question types</li><li>Scoring strategies and time management</li><li>Full-length practice tests</li><li>Common pitfalls and how to avoid them</li></ul><p>Essential for students planning to study in English-speaking countries.</p>',
                'tags' => ['toefl', 'exam', 'test preparation', 'advanced'],
                'duration' => '22h 00m',
                'status' => true,
            ],
            [
                'title' => 'English for Travelers',
                'short_description' => '<p>Essential English phrases and vocabulary for traveling, including airport, hotel, restaurant, and emergency situations.</p>',
                'long_description' => '<p>Learn the English you need for traveling abroad. This practical course includes:</p><ul><li>Airport and flight vocabulary</li><li>Hotel check-in and accommodation</li><li>Restaurant and ordering food</li><li>Shopping and bargaining</li><li>Emergency situations and asking for help</li></ul><p>Perfect for travelers who want to communicate confidently during their trips.</p>',
                'tags' => ['travel', 'practical', 'beginner', 'vocabulary'],
                'duration' => '8h 45m',
                'status' => true,
            ],
            [
                'title' => 'Advanced English Literature',
                'short_description' => '<p>Explore classic and modern English literature, analyze texts, and develop critical reading and interpretation skills.</p>',
                'long_description' => '<p>Dive deep into English literature with this advanced course. You will study:</p><ul><li>Classic English literature (Shakespeare, Dickens, Austen)</li><li>Modern and contemporary works</li><li>Literary analysis and criticism</li><li>Poetry and prose analysis</li><li>Cultural and historical context</li></ul><p>Ideal for advanced learners interested in literature and literary analysis.</p>',
                'tags' => ['literature', 'advanced', 'reading', 'analysis'],
                'duration' => '25h 00m',
                'status' => true,
            ],
            [
                'title' => 'English for Kids - Fun Learning',
                'short_description' => '<p>Interactive and engaging English lessons for children with games, songs, stories, and colorful activities.</p>',
                'long_description' => '<p>Make learning English fun for kids! This course features:</p><ul><li>Interactive games and activities</li><li>Children\'s songs and rhymes</li><li>Storytelling and reading</li><li>Basic vocabulary and simple grammar</li><li>Colorful visuals and animations</li></ul><p>Designed for young learners aged 5-12 years old.</p>',
                'tags' => ['kids', 'children', 'beginner', 'fun'],
                'duration' => '6h 30m',
                'status' => true,
            ],
            [
                'title' => 'Medical English for Healthcare Professionals',
                'short_description' => '<p>Specialized English course for healthcare workers covering medical terminology, patient communication, and documentation.</p>',
                'long_description' => '<p>Master medical English for your healthcare career. This specialized course covers:</p><ul><li>Medical terminology and vocabulary</li><li>Patient communication skills</li><li>Medical documentation and reports</li><li>Case presentations</li><li>Professional medical writing</li></ul><p>Essential for doctors, nurses, and healthcare professionals working in English-speaking environments.</p>',
                'tags' => ['medical', 'healthcare', 'professional', 'specialized'],
                'duration' => '19h 30m',
                'status' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create([
                'title' => $courseData['title'],
                'slug' => Str::slug($courseData['title']),
                'short_description' => $courseData['short_description'],
                'long_description' => $courseData['long_description'],
                'tags' => $courseData['tags'],
                'duration' => $courseData['duration'],
                'status' => $courseData['status'],
            ]);
        }
    }
}
