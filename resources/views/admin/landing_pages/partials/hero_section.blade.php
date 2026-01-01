<!-- Hero Section Tab -->
<div x-show="activeTab === 'hero'" class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Hero Section</h2>
      <p class="text-sm text-gray-500">Main banner area at the top of the landing page</p>
    </div>

    <div class="space-y-6">
      <x-forms.input name="hero_english_title" label="English Title" 
                     :value="old('hero_english_title', isset($landingPage) ? $landingPage->hero_english_title : '')" 
                     :error="$errors->first('hero_english_title')"
                     placeholder="SPOKEN ENGLISH IN REAL LIFE" 
                     help="Main English title (will be displayed in uppercase)" />
      
      <x-forms.textarea name="hero_bengali_title" label="Bengali Title" 
                        :value="old('hero_bengali_title', isset($landingPage) ? $landingPage->hero_bengali_title : '')" 
                        rows="3"
                        :error="$errors->first('hero_bengali_title')" 
                        placeholder="ইংরেজি শেখার একমাত্র বই..." 
                        help="Bengali subtitle/description for the hero section" />
      
      <x-forms.image-uploader name="hero_main_image" label="Main Hero Image" 
                              :value="old('hero_main_image', isset($landingPage) && $landingPage->hero_main_image ? Storage::url($landingPage->hero_main_image) : '')" 
                              accept="image/*" maxSize="2MB" 
                              :error="$errors->first('hero_main_image')"
                              help="Main book image displayed prominently in the hero section (Recommended: 600x800px)" />
      
      @if(isset($landingPage) && $landingPage->hero_main_image)
        <div class="flex items-center gap-2">
          <input type="checkbox" name="hero_main_image_remove" id="hero_main_image_remove" value="1" 
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="hero_main_image_remove" class="text-sm text-gray-700">Remove current image</label>
        </div>
      @endif

      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Hero Preview Images</label>
        <p class="mb-3 text-xs text-gray-500">Upload multiple preview images for the carousel below the main hero content</p>
        
        @if(isset($landingPage) && $landingPage->hero_preview_images && count($landingPage->hero_preview_images) > 0)
          <div class="mb-3 grid grid-cols-4 gap-2">
            @foreach($landingPage->hero_preview_images as $image)
              <div class="relative">
                <img src="{{ Storage::url($image) }}" alt="" class="h-20 w-full rounded object-cover">
                <input type="checkbox" name="remove_preview_images[]" value="{{ $image }}" 
                       class="absolute top-1 right-1 h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                       title="Remove this image">
              </div>
            @endforeach
          </div>
        @endif
        
        <input type="file" name="hero_preview_images[]" multiple accept="image/*"
               class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none">
        <p class="mt-1 text-xs text-gray-500">You can select multiple images. Recommended size: 400x600px per image</p>
        <x-forms.error :message="$errors->first('hero_preview_images.*')" />
      </div>
    </div>
  </x-card>
</div>

