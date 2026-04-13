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
