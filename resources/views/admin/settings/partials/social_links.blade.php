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

  <x-forms.input name="whatsapp_number" label="WhatsApp Number" type="text" :value="old('whatsapp_number', $settings['whatsapp_number'] ?? '')" :error="$errors->first('whatsapp_number')"
                 placeholder="+8801234567890" />
</div>
</x-card>
