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

  <div class="col-span-1 md:col-span-2">
      <x-forms.label for="map_embed_url">Google Maps Embed URL</x-forms.label>
      <textarea id="map_embed_url" name="map_embed_url" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-mono text-xs" placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed_url', $settings['map_embed_url'] ?? '') }}</textarea>
      <p class="mt-1 text-xs text-gray-500">Paste the embed URL from Google Maps → Share → Embed a map → Copy the <code>src</code> attribute value. Leave blank to hide the map on the Contact page.</p>
      <x-forms.error :message="$errors->first('map_embed_url')" />
  </div>
</div>
</x-card>
