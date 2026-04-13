<!-- SEO & Analytics Settings -->
<x-card variant="elevated">
<div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
  <h2 class="text-lg font-medium text-gray-900">SEO & Analytics</h2>
  <p class="text-sm text-gray-500">Configure global metadata, SEO tools, and analytics tracking</p>
</div>

<div class="space-y-8">
  
  <!-- Global Meta Configurations -->
  <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
    <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-gray-900">
      Global Meta Data
    </h3>
    
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
      <x-forms.input name="seo_meta_title" label="Global Meta Title" type="text" :value="old('seo_meta_title', $settings['seo_meta_title'] ?? '')" :error="$errors->first('seo_meta_title')"
                     placeholder="Darpon - Edutech Platform" />
                     
      <x-forms.input name="seo_meta_author" label="Meta Author" type="text" :value="old('seo_meta_author', $settings['seo_meta_author'] ?? '')" :error="$errors->first('seo_meta_author')"
                     placeholder="Nix Software" />                             
                     
      <div class="col-span-1 md:col-span-2 space-y-1">
        <x-forms.label for="seo_meta_keywords">Meta Keywords</x-forms.label>
        <textarea id="seo_meta_keywords" name="seo_meta_keywords" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="education, platform, learning, courses">{{ old('seo_meta_keywords', $settings['seo_meta_keywords'] ?? '') }}</textarea>
        <x-forms.error :message="$errors->first('seo_meta_keywords')" />
      </div>
      
      <div class="col-span-1 md:col-span-2 space-y-1">
        <x-forms.label for="seo_meta_description">Meta Description</x-forms.label>
        <textarea id="seo_meta_description" name="seo_meta_description" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="Darpon is a premier online learning platform providing top tier courses...">{{ old('seo_meta_description', $settings['seo_meta_description'] ?? '') }}</textarea>
        <x-forms.error :message="$errors->first('seo_meta_description')" />
      </div>

      <!-- OG Image -->
      <div class="col-span-1 md:col-span-2 min-w-0 pt-4">
        <x-forms.image-uploader name="seo_og_image" label="Open Graph (OG) Image" :value="!empty($settings['seo_og_image']) ? Storage::url($settings['seo_og_image']) : ''" :error="$errors->first('seo_og_image')"
                                help="Image displayed when a link is shared on social media (Facebook, Twitter, LinkedIn)"
                                accept="image/*" maxSize="2MB" />
      </div>
    </div>
  </div>

  <!-- Tools and Analytics -->
  <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
    <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-gray-900">
      Sitemaps & Analytics
    </h3>
    
    <div class="space-y-6">
      <div>
        <x-forms.input name="sitemap_url" label="Sitemap URL" type="url" :value="old('sitemap_url', $settings['sitemap_url'])" :error="$errors->first('sitemap_url')"
                       placeholder="https://yoursite.com/sitemap.xml" />
        <p class="mt-1 text-xs text-gray-500 mb-2">
          The URL to your sitemap.xml file. This helps search engines discover and index your pages.
        </p>
        <button type="submit" formaction="{{ route('admin.settings.sitemap') }}" formmethod="POST"
          class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          <svg class="-ml-0.5 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          Regenerate Sitemap
        </button>
      </div>

      <div>
        <x-forms.input name="rss_feed_url" label="RSS Feed URL" type="url" :value="old('rss_feed_url', !empty($settings['rss_feed_url']) ? $settings['rss_feed_url'] : url('/feed'))" :error="$errors->first('rss_feed_url')"
                       placeholder="https://yoursite.com/feed" />
        <p class="mt-1 text-xs text-gray-500 mb-2">
          The URL to your RSS feed. This allows users to globally subscribe to Video Blogs, Courses, and Books.
        </p>
        <a href="{{ url('/feed') }}" target="_blank"
          class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          <svg class="-ml-0.5 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
          </svg>
          View Live Feed
        </a>
      </div>

      <div>
        <x-forms.input name="google_analytics_id" label="Google Analytics ID" type="text" :value="old('google_analytics_id', $settings['google_analytics_id'])" :error="$errors->first('google_analytics_id')"
                       placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X" />
        <p class="mt-1 text-xs text-gray-500">
          Your Google Analytics tracking ID (e.g., G-XXXXXXXXXX for GA4 or UA-XXXXXXXXX-X for Universal Analytics).
          This will be used to track website traffic and user behavior.
        </p>
      </div>
    </div>
  </div>
</div>
</x-card>
