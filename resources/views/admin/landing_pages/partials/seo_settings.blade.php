@php
  $formAction = isset($landingPage) 
    ? route('admin.landing-pages.update-partial', $landingPage)
    : route('admin.landing-pages.store-partial');
@endphp

<!-- SEO & Settings Tab -->
<div class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">SEO Settings</h2>
      <p class="text-sm text-gray-500">Optimize your landing page for search engines and social media sharing</p>
    </div>

    <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
      @csrf
      @if(isset($landingPage))
        @method('PUT')
      @endif
      <input type="hidden" name="tab" value="seo">

      <div class="space-y-6">
      <x-forms.input name="meta_title" label="Meta Title" 
                     :value="old('meta_title', isset($landingPage) ? $landingPage->meta_title : '')" 
                     :error="$errors->first('meta_title')"
                     placeholder="SEO title (50-60 characters recommended)" 
                     help="Title for search engines and browser tabs. Should be descriptive and include keywords." />
      
      <x-forms.textarea name="meta_description" label="Meta Description" 
                        :value="old('meta_description', isset($landingPage) ? $landingPage->meta_description : '')" 
                        rows="3"
                        :error="$errors->first('meta_description')"
                        placeholder="SEO description (150-160 characters recommended)"
                        help="Brief description that appears in search engine results. Should be compelling and include key information." />
      
      <x-forms.image-uploader name="meta_image" label="Meta Image (OG Image)" 
                              :value="old('meta_image', isset($landingPage) && $landingPage->meta_image ? Storage::url($landingPage->meta_image) : '')"
                              accept="image/*" maxSize="2MB" 
                              :error="$errors->first('meta_image')"
                              help="Image for social media sharing (1200x630px recommended). This image appears when the page is shared on Facebook, Twitter, LinkedIn, etc." />
      
      @if(isset($landingPage) && $landingPage->meta_image)
        <div class="flex items-center gap-2">
          <input type="checkbox" name="meta_image_remove" id="meta_image_remove" value="1" 
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="meta_image_remove" class="text-sm text-gray-700">Remove current image</label>
        </div>
      @endif

      <div class="rounded-md bg-blue-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">SEO Best Practices</h3>
            <div class="mt-2 text-sm text-blue-700">
              <ul class="list-disc space-y-1 pl-5">
                <li><strong>Meta Title:</strong> Keep it between 50-60 characters. Include the book name and key benefit.</li>
                <li><strong>Meta Description:</strong> Keep it between 150-160 characters. Write a compelling summary that encourages clicks.</li>
                <li><strong>Meta Image:</strong> Use high-quality images (1200x630px) that represent your book well. Images with text should be readable at small sizes.</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=seo"
             class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
            Cancel
          </a>
          <x-button type="submit" variant="primary" size="md">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ isset($landingPage) ? 'Update SEO Settings' : 'Save SEO Settings' }}
          </x-button>
        </div>
      </div>
    </form>
  </x-card>
</div>

