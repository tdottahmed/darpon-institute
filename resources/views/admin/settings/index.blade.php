@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
        <p class="mt-1 text-sm text-gray-600">Manage site-wide configuration and API credentials</p>
      </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
      @csrf

      <!-- Steadfast Courier API Settings -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Steadfast Courier API</h2>
          <p class="text-sm text-gray-500">Configure API credentials for shipping integration</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <x-forms.input name="steadfast_api_key" label="API Key" type="text" :value="old('steadfast_api_key', $settings['steadfast_api_key'])" :error="$errors->first('steadfast_api_key')"
                         placeholder="Enter API Key from Steadfast Dashboard" />

          <div class="space-y-1">
            <label for="steadfast_secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
            <input type="password" name="steadfast_secret_key" id="steadfast_secret_key"
                   value="{{ old('steadfast_secret_key', $settings['steadfast_secret_key']) }}"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                   placeholder="Enter Secret Key">
            @if ($errors->has('steadfast_secret_key'))
              <p class="mt-1 text-sm text-red-600">{{ $errors->first('steadfast_secret_key') }}</p>
            @endif
          </div>
        </div>
      </x-card>

      <!-- Fraud Check Credentials -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Fraud Check Credentials</h2>
          <p class="text-sm text-gray-500">Configure credentials for courier fraud checking service</p>
          <p class="mt-1 text-xs text-gray-400">These settings will override values in your .env file</p>
        </div>

        <div class="space-y-8">
          <!-- Pathao Credentials -->
          <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
            <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-gray-900">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Pathao Credentials
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="pathao_user" label="Email/Username" type="email" :value="old('pathao_user', $settings['pathao_user'])" :error="$errors->first('pathao_user')"
                             placeholder="developertanbir1@gmail.com" />

              <div class="space-y-1">
                <label for="pathao_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="pathao_password" id="pathao_password"
                       value="{{ old('pathao_password', $settings['pathao_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Pathao password">
                @if ($errors->has('pathao_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('pathao_password') }}</p>
                @endif
              </div>
            </div>
          </div>

          <!-- Steadfast Credentials -->
          <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
            <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-gray-900">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Steadfast Credentials (Fraud Check)
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="steadfast_user" label="Email/Username" type="email" :value="old('steadfast_user', $settings['steadfast_user'])"
                             :error="$errors->first('steadfast_user')" placeholder="developertanbir1@gmail.com" />

              <div class="space-y-1">
                <label for="steadfast_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="steadfast_password" id="steadfast_password"
                       value="{{ old('steadfast_password', $settings['steadfast_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Steadfast password">
                @if ($errors->has('steadfast_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('steadfast_password') }}</p>
                @endif
              </div>
            </div>
          </div>

          <!-- Redex Credentials -->
          <div>
            <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-gray-900">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Redex Credentials
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="redx_phone" label="Phone Number" type="text" :value="old('redx_phone', $settings['redx_phone'])" :error="$errors->first('redx_phone')"
                             placeholder="01345274871" />

              <div class="space-y-1">
                <label for="redx_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="redx_password" id="redx_password"
                       value="{{ old('redx_password', $settings['redx_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Redex password">
                @if ($errors->has('redx_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('redx_password') }}</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </x-card>

      <!-- Meta Pixel Settings -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Meta Pixel (Facebook Pixel)</h2>
          <p class="text-sm text-gray-500">Configure Meta Pixel for tracking and analytics</p>
        </div>

        <div class="space-y-6">
          <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-4">
            <div class="flex-1">
              <label for="meta_pixel_enabled" class="block text-sm font-medium text-gray-900">
                Enable Meta Pixel
              </label>
              <p class="mt-1 text-xs text-gray-500">Enable or disable Meta Pixel tracking on your website</p>
            </div>
            <div class="ml-4">
              <input type="hidden" name="meta_pixel_enabled" value="0">
              <input type="checkbox" name="meta_pixel_enabled" id="meta_pixel_enabled" value="1"
                     {{ old('meta_pixel_enabled', $settings['meta_pixel_enabled']) == '1' || old('meta_pixel_enabled', $settings['meta_pixel_enabled']) == 1 ? 'checked' : '' }}
                     class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
            </div>
          </div>

          <div>
            <x-forms.input name="meta_pixel_id" label="Pixel ID" type="text" :value="old('meta_pixel_id', $settings['meta_pixel_id'])" :error="$errors->first('meta_pixel_id')"
                           placeholder="Enter your Meta Pixel ID (e.g., 123456789012345)" />
            <p class="mt-1 text-xs text-gray-500">
              You can find your Pixel ID in your Meta Events Manager. The Pixel ID is a 15-16 digit number.
            </p>
          </div>

          @if ($settings['meta_pixel_id'])
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
              <div class="flex items-start gap-3">
                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <p class="text-sm font-medium text-blue-900">Pixel Status</p>
                  <p class="mt-1 text-xs text-blue-700">
                    @if ($settings['meta_pixel_enabled'] == '1' || $settings['meta_pixel_enabled'] == 1)
                      Meta Pixel is <strong>enabled</strong> and will track events on your website.
                    @else
                      Meta Pixel is <strong>disabled</strong>. Enable it to start tracking.
                    @endif
                  </p>
                </div>
              </div>
            </div>
          @endif
        </div>
      </x-card>

      <!-- Social Media Links -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Social Media Links</h2>
          <p class="text-sm text-gray-500">Configure social media links displayed in the footer</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <x-forms.input name="social_facebook" label="Facebook URL" type="url" :value="old('social_facebook', $settings['social_facebook'])"
                         :error="$errors->first('social_facebook')" placeholder="https://facebook.com/yourpage" />

          <x-forms.input name="social_instagram" label="Instagram URL" type="url" :value="old('social_instagram', $settings['social_instagram'])"
                         :error="$errors->first('social_instagram')" placeholder="https://instagram.com/yourpage" />

          <x-forms.input name="social_twitter" label="Twitter/X URL" type="url" :value="old('social_twitter', $settings['social_twitter'])"
                         :error="$errors->first('social_twitter')" placeholder="https://twitter.com/yourpage" />

          <x-forms.input name="social_youtube" label="YouTube URL" type="url" :value="old('social_youtube', $settings['social_youtube'])" :error="$errors->first('social_youtube')"
                         placeholder="https://youtube.com/yourchannel" />
        </div>
      </x-card>

      <!-- Company Information -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Company Information</h2>
          <p class="text-sm text-gray-500">Configure company address and contact details displayed in the footer</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <div class="col-span-1 md:col-span-2">
              <x-forms.label for="company_address">Company Address</x-forms.label>
              <textarea id="company_address" name="company_address" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="123 Example Street, City, Country">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
              <x-forms.error :message="$errors->first('company_address')" />
          </div>

          <x-forms.input name="company_phone" label="Phone Number" type="text" :value="old('company_phone', $settings['company_phone'] ?? '')"
                         :error="$errors->first('company_phone')" placeholder="+880 1234 567890" />

          <x-forms.input name="company_email" label="Contact Email" type="email" :value="old('company_email', $settings['company_email'] ?? '')"
                         :error="$errors->first('company_email')" placeholder="contact@example.com" />
        </div>
      </x-card>

      <!-- SEO & Analytics Settings -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">SEO & Analytics</h2>
          <p class="text-sm text-gray-500">Configure SEO tools and analytics tracking</p>
        </div>

        <div class="space-y-6">
          <div>
            <x-forms.input name="sitemap_url" label="Sitemap URL" type="url" :value="old('sitemap_url', $settings['sitemap_url'])" :error="$errors->first('sitemap_url')"
                           placeholder="https://yoursite.com/sitemap.xml" />
            <p class="mt-1 text-xs text-gray-500">
              The URL to your sitemap.xml file. This helps search engines discover and index your pages.
            </p>
          </div>

          <div>
            <x-forms.input name="rss_feed_url" label="RSS Feed URL" type="url" :value="old('rss_feed_url', $settings['rss_feed_url'])" :error="$errors->first('rss_feed_url')"
                           placeholder="https://yoursite.com/feed" />
            <p class="mt-1 text-xs text-gray-500">
              The URL to your RSS feed. This allows users and feed readers to subscribe to your content updates.
            </p>
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
      </x-card>

      <!-- Logo Settings -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Logo Settings</h2>
          <p class="text-sm text-gray-500">Upload logos for light and dark themes</p>
        </div>

        <!-- Light Logo -->
        <div class="min-w-0">
          <x-forms.image-uploader name="logo_light" label="Light Logo" :value="!empty($settings['logo_light']) ? Storage::url($settings['logo_light']) : ''" :error="$errors->first('logo_light')"
                                  help="Logo displayed on light backgrounds (recommended: transparent PNG)"
                                  accept="image/*" maxSize="2MB" />
        </div>

        <!-- Dark Logo -->
        <div class="min-w-0">
          <x-forms.image-uploader name="logo_dark" label="Dark Logo" :value="!empty($settings['logo_dark']) ? Storage::url($settings['logo_dark']) : ''" :error="$errors->first('logo_dark')"
                                  help="Logo displayed on dark backgrounds (recommended: white/light colored logo). If not provided, light logo will be used as fallback."
                                  accept="image/*" maxSize="2MB" />
        </div>

        <!-- Header & Footer Colors -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <div class="space-y-1">
            <label for="header_footer_color_light" class="block text-sm font-medium text-gray-700">Light Mode Header/Footer Color</label>
            <div class="flex items-center gap-3">
              <input type="color" name="header_footer_color_light" id="header_footer_color_light_picker"
                     value="{{ old('header_footer_color_light', $settings['header_footer_color_light']) }}"
                     class="h-10 w-20 rounded border border-gray-300 p-1"
                     oninput="document.getElementById('header_footer_color_light_text').value = this.value">
              <input type="text" name="header_footer_color_light" id="header_footer_color_light_text"
                     value="{{ old('header_footer_color_light', $settings['header_footer_color_light']) }}"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                     oninput="document.getElementById('header_footer_color_light_picker').value = this.value">
            </div>
            <p class="text-xs text-gray-500 mt-1">Background color for header and footer in light mode.</p>
            @if ($errors->has('header_footer_color_light'))
              <p class="mt-1 text-sm text-red-600">{{ $errors->first('header_footer_color_light') }}</p>
            @endif
          </div>

          <div class="space-y-1">
            <label for="header_footer_color_dark" class="block text-sm font-medium text-gray-700">Dark Mode Header/Footer Color</label>
            <div class="flex items-center gap-3">
              <input type="color" name="header_footer_color_dark" id="header_footer_color_dark_picker"
                     value="{{ old('header_footer_color_dark', $settings['header_footer_color_dark']) }}"
                     class="h-10 w-20 rounded border border-gray-300 p-1"
                     oninput="document.getElementById('header_footer_color_dark_text').value = this.value">
              <input type="text" name="header_footer_color_dark" id="header_footer_color_dark_text"
                     value="{{ old('header_footer_color_dark', $settings['header_footer_color_dark']) }}"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                     oninput="document.getElementById('header_footer_color_dark_picker').value = this.value">
            </div>
            <p class="text-xs text-gray-500 mt-1">Background color for header and footer in dark mode.</p>
            @if ($errors->has('header_footer_color_dark'))
              <p class="mt-1 text-sm text-red-600">{{ $errors->first('header_footer_color_dark') }}</p>
            @endif
          </div>

          <div class="space-y-1">
            <label for="header_footer_text_color_light" class="block text-sm font-medium text-gray-700">Light Mode Header/Footer Text Color</label>
            <div class="flex items-center gap-3">
              <input type="color" name="header_footer_text_color_light" id="header_footer_text_color_light_picker"
                     value="{{ old('header_footer_text_color_light', $settings['header_footer_text_color_light']) }}"
                     class="h-10 w-20 rounded border border-gray-300 p-1"
                     oninput="document.getElementById('header_footer_text_color_light_text').value = this.value">
              <input type="text" name="header_footer_text_color_light" id="header_footer_text_color_light_text"
                     value="{{ old('header_footer_text_color_light', $settings['header_footer_text_color_light']) }}"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                     oninput="document.getElementById('header_footer_text_color_light_picker').value = this.value">
            </div>
            <p class="text-xs text-gray-500 mt-1">Text color for header and footer in light mode.</p>
            @if ($errors->has('header_footer_text_color_light'))
              <p class="mt-1 text-sm text-red-600">{{ $errors->first('header_footer_text_color_light') }}</p>
            @endif
          </div>

          <div class="space-y-1">
            <label for="header_footer_text_color_dark" class="block text-sm font-medium text-gray-700">Dark Mode Header/Footer Text Color</label>
            <div class="flex items-center gap-3">
              <input type="color" name="header_footer_text_color_dark" id="header_footer_text_color_dark_picker"
                     value="{{ old('header_footer_text_color_dark', $settings['header_footer_text_color_dark']) }}"
                     class="h-10 w-20 rounded border border-gray-300 p-1"
                     oninput="document.getElementById('header_footer_text_color_dark_text').value = this.value">
              <input type="text" name="header_footer_text_color_dark" id="header_footer_text_color_dark_text"
                     value="{{ old('header_footer_text_color_dark', $settings['header_footer_text_color_dark']) }}"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                     oninput="document.getElementById('header_footer_text_color_dark_picker').value = this.value">
            </div>
            <p class="text-xs text-gray-500 mt-1">Text color for header and footer in dark mode.</p>
            @if ($errors->has('header_footer_text_color_dark'))
              <p class="mt-1 text-sm text-red-600">{{ $errors->first('header_footer_text_color_dark') }}</p>
            @endif
          </div>
        </div>

        <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4">
          <div class="flex items-start gap-3">
            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-sm font-medium text-blue-900">Logo Usage</p>
              <p class="mt-1 text-xs text-blue-700">
                The light logo is used by default. If a dark logo is uploaded, it will automatically be used when the site
                is in dark mode.
                If no dark logo is provided, the light logo will be used for both themes.
              </p>
            </div>
          </div>
        </div>
      </x-card>

      <!-- Submit Button -->
      <div class="flex items-center justify-end gap-4 pt-2">
        <x-button type="submit" variant="primary" size="md">
          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Save All Settings
        </x-button>
      </div>
    </form>
  </div>
@endsection
