<!-- Meta Pixel Settings -->
<x-card variant="elevated">
  <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
    <h2 class="text-lg font-medium text-gray-900">Meta Pixel (Facebook Pixel)</h2>
    <p class="text-sm text-gray-500">Track visitor behaviour and conversions for Facebook/Instagram ads</p>
  </div>

  <div class="space-y-6">

    {{-- How to find your Pixel ID --}}
    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
      <p class="mb-3 text-sm font-semibold text-gray-700">How to set up Meta Pixel</p>
      <ol class="space-y-2 text-sm text-gray-600">
        <li class="flex gap-2">
          <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">1</span>
          <span>Go to <a href="https://business.facebook.com/events_manager" target="_blank" rel="noopener noreferrer" class="font-medium text-primary-600 underline hover:text-primary-800">Meta Events Manager</a> and sign in with your Business account.</span>
        </li>
        <li class="flex gap-2">
          <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">2</span>
          <span>Click <strong>Connect Data Sources</strong> → <strong>Web</strong> → <strong>Meta Pixel</strong> and give it a name.</span>
        </li>
        <li class="flex gap-2">
          <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">3</span>
          <span>Copy the <strong>Pixel ID</strong> — a 15–16 digit number shown under the pixel name — and paste it below.</span>
        </li>
        <li class="flex gap-2">
          <span class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">4</span>
          <span>Enable the toggle, save settings, then verify using the <a href="https://chromewebstore.google.com/detail/meta-pixel-helper/fdgfkebogiimcoedlicjlajpkdmockpc" target="_blank" rel="noopener noreferrer" class="font-medium text-primary-600 underline hover:text-primary-800">Meta Pixel Helper</a> Chrome extension.</span>
        </li>
      </ol>
      <p class="mt-3 text-xs text-gray-500">
        The pixel fires a <strong>PageView</strong> event automatically on every page of both the main site and landing pages.
      </p>
    </div>

    {{-- Enable toggle --}}
    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-4">
      <div class="flex-1">
        <label for="meta_pixel_enabled" class="block text-sm font-medium text-gray-900">
          Enable Meta Pixel
        </label>
        <p class="mt-1 text-xs text-gray-500">No Pixel ID? Leave this off — it has no effect without one.</p>
      </div>
      <div class="ml-4">
        <input type="hidden" name="meta_pixel_enabled" value="0">
        <input type="checkbox" name="meta_pixel_enabled" id="meta_pixel_enabled" value="1"
               {{ old('meta_pixel_enabled', $settings['meta_pixel_enabled']) == '1' || old('meta_pixel_enabled', $settings['meta_pixel_enabled']) == 1 ? 'checked' : '' }}
               class="h-5 w-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
      </div>
    </div>

    {{-- Pixel ID input --}}
    <div>
      <x-forms.input name="meta_pixel_id" label="Pixel ID" type="text"
                     :value="old('meta_pixel_id', $settings['meta_pixel_id'])"
                     :error="$errors->first('meta_pixel_id')"
                     placeholder="e.g. 123456789012345" />
      <p class="mt-1 text-xs text-gray-500">
        Only digits, 15–16 characters. Found in Events Manager under your pixel's name.
      </p>
    </div>

    {{-- Live status badge --}}
    @if ($settings['meta_pixel_id'])
      <div class="rounded-lg border p-4
        {{ ($settings['meta_pixel_enabled'] == '1' || $settings['meta_pixel_enabled'] == 1)
            ? 'border-green-200 bg-green-50'
            : 'border-yellow-200 bg-yellow-50' }}">
        <div class="flex items-start gap-3">
          @if ($settings['meta_pixel_enabled'] == '1' || $settings['meta_pixel_enabled'] == 1)
            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-sm font-medium text-green-900">Pixel is <strong>active</strong></p>
              <p class="mt-0.5 text-xs text-green-700">
                ID <code class="rounded bg-green-100 px-1 font-mono">{{ $settings['meta_pixel_id'] }}</code>
                is firing PageView events on all pages.
                Use the <a href="https://chromewebstore.google.com/detail/meta-pixel-helper/fdgfkebogiimcoedlicjlajpkdmockpc" target="_blank" rel="noopener noreferrer" class="underline hover:text-green-900">Pixel Helper</a> extension to verify.
              </p>
            </div>
          @else
            <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
              <p class="text-sm font-medium text-yellow-900">Pixel is <strong>disabled</strong></p>
              <p class="mt-0.5 text-xs text-yellow-700">
                ID <code class="rounded bg-yellow-100 px-1 font-mono">{{ $settings['meta_pixel_id'] }}</code>
                is saved but not firing. Enable the toggle above to activate tracking.
              </p>
            </div>
          @endif
        </div>
      </div>
    @endif

  </div>
</x-card>
