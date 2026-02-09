<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Course;
use App\Models\Book;
use App\Models\VideoBlog;
use App\Models\LandingPage;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml manually providing routes';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap...');

        // Force set APP_URL to live site for this command execution
        $baseUrl = 'https://darponbd.com';
        \Illuminate\Support\Facades\URL::forceRootUrl($baseUrl);
        \Illuminate\Support\Facades\URL::forceScheme('https');


        try {
            $sitemap = Sitemap::create();

            // 1. Static Pages
            $this->info('Adding static pages...');
            $sitemap->add(Url::create(route('home')))
                    ->add(Url::create(route('courses.index')))
                    ->add(Url::create(route('books.index')))
                    ->add(Url::create(route('video_blogs.index')))
                    ->add(Url::create(route('galleries.index')))
                    ->add(Url::create(route('about')))
                    ->add(Url::create(route('contact')));

            // 2. Dynamic Content: Courses
            $this->info('Adding courses...');
            Course::all()->each(function (Course $course) use ($sitemap) {
                $sitemap->add(Url::create(route('courses.show', $course->slug)));
            });

            // 3. Dynamic Content: Books
            $this->info('Adding books...');
            Book::all()->each(function (Book $book) use ($sitemap) {
                $sitemap->add(Url::create(route('books.show', $book->slug)));
            });

            // 4. Dynamic Content: Video Blogs
            $this->info('Adding video blogs...');
            VideoBlog::all()->each(function (VideoBlog $videoBlog) use ($sitemap) {
                $sitemap->add(Url::create(route('video_blogs.show', $videoBlog->slug)));
            });

            // 5. Dynamic Content: Landing Pages
            // Only include active landing pages if there's a status field, assuming all for now or check structure
            // Based on previous file view, LandingPage model exists.
            $this->info('Adding landing pages...');
            LandingPage::all()->each(function (LandingPage $lp) use ($sitemap) {
                // Assuming the route param is 'slug' based on routes/web.php: Route::get('/lp/{slug}', ...)
                if ($lp->slug) {
                     $sitemap->add(Url::create(route('landing-page.show', $lp->slug)));
                }
            });

            // Write to file
            $sitemap->writeToFile(public_path('sitemap.xml'));

            $this->info('Sitemap generated successfully at: ' . public_path('sitemap.xml'));
            
            // Update the sitemap_url setting
            $sitemapUrl = $baseUrl . '/sitemap.xml';
            \App\Models\Setting::set('sitemap_url', $sitemapUrl);
            $this->info('Sitemap URL updated in settings: ' . $sitemapUrl);
            
            // Also update the RSS feed URL if not already set
            $rssFeedUrl = \App\Models\Setting::get('rss_feed_url');
            if (!$rssFeedUrl) {
                $rssFeedUrl = $baseUrl . '/feed';
                \App\Models\Setting::set('rss_feed_url', $rssFeedUrl);
                $this->info('RSS Feed URL updated in settings: ' . $rssFeedUrl);
            }

            $rssFeedUrlCourses = \App\Models\Setting::get('rss_feed_url_courses');
            if (!$rssFeedUrlCourses) {
                $rssFeedUrlCourses = $baseUrl . '/feed/courses';
                \App\Models\Setting::set('rss_feed_url_courses', $rssFeedUrlCourses);
                $this->info('Courses RSS Feed URL updated in settings: ' . $rssFeedUrlCourses);
            }

            $rssFeedUrlBooks = \App\Models\Setting::get('rss_feed_url_books');
            if (!$rssFeedUrlBooks) {
                $rssFeedUrlBooks = $baseUrl . '/feed/books';
                \App\Models\Setting::set('rss_feed_url_books', $rssFeedUrlBooks);
                $this->info('Books RSS Feed URL updated in settings: ' . $rssFeedUrlBooks);
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate sitemap: ' . $e->getMessage());
            // Log the full error for debugging
             \Illuminate\Support\Facades\Log::error('Sitemap generation failed: ' . $e);
            return Command::FAILURE;
        }
    }
}
