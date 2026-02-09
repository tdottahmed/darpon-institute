<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

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
    protected $description = 'Generate sitemap.xml by crawling the website';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating sitemap...');

        $baseUrl = config('app.url');
        
        if (!$baseUrl) {
            $this->error('APP_URL is not set in your .env file.');
            return Command::FAILURE;
        }

        try {
            SitemapGenerator::create($baseUrl)
                ->writeToFile(public_path('sitemap.xml'));

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

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate sitemap: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
