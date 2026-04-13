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
