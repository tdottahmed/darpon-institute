@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Landing Page</h1>
        <p class="mt-1 text-sm text-gray-600">Edit landing page details</p>
      </div>
      <x-ui.link href="{{ route('admin.landing-pages.index') }}" variant="default">
        ← Back to Landing Pages
      </x-ui.link>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.landing-pages.update', $landingPage) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      @method('PUT')

      <!-- Basic Information -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
          <p class="text-sm text-gray-500">Essential details for the landing page</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="title" label="Title" :value="old('title', $landingPage->title)" required :error="$errors->first('title')" id="landing-title"
                         placeholder="Enter landing page title" />
          <x-forms.input name="slug" label="Slug" :value="old('slug', $landingPage->slug)" required :error="$errors->first('slug')"
                         help="URL-friendly version (e.g., special-course-offer)" id="landing-slug" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
            <x-forms.select name="product_type" label="Product Type" :options="[
                '' => 'Select Product Type',
                'course' => 'Course',
                'book' => 'Book',
            ]" :value="old('product_type', $landingPage->product_type)" required :error="$errors->first('product_type')" id="product-type" />
          </div>
          <div>
            <x-forms.select name="product_id" label="Select Product" :options="[]" :value="old('product_id', $landingPage->product_id)" required
                            :error="$errors->first('product_id')" id="product-id"
                            help="Select a product after choosing product type" />
          </div>
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', $landingPage->status) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>
      </x-card>

      <!-- Hero Section -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Hero Section</h2>
          <p class="text-sm text-gray-500">Main banner area at the top of the landing page</p>
        </div>

        <div class="space-y-6">
          <x-forms.input name="hero_title" label="Hero Title" :value="old('hero_title', $landingPage->hero_title)" :error="$errors->first('hero_title')"
                         placeholder="Main headline for the hero section" />
          <x-forms.textarea name="hero_subtitle" label="Hero Subtitle" :value="old('hero_subtitle', $landingPage->hero_subtitle)" rows="3"
                            :error="$errors->first('hero_subtitle')" placeholder="Supporting text below the title" />
          <x-forms.image-uploader name="hero_image" label="Hero Image" :value="old('hero_image', $landingPage->hero_image ? Storage::url($landingPage->hero_image) : '')" accept="image/*"
                                  maxSize="2MB" :error="$errors->first('hero_image')" />
          @if($landingPage->hero_image)
            <div class="flex items-center gap-2">
              <input type="checkbox" name="hero_image_remove" id="hero_image_remove" value="1" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <label for="hero_image_remove" class="text-sm text-gray-700">Remove current image</label>
            </div>
          @endif

          <div x-data="{ videoType: '{{ old('hero_video_type', $landingPage->hero_video_type ?? '') }}' }">
            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Video Type</label>
            <div class="flex space-x-4 mb-4">
              <label class="flex items-center space-x-2 cursor-pointer">
                <input type="radio" name="hero_video_type" value="url" x-model="videoType"
                       class="text-primary-600 focus:ring-primary-500">
                <span>Video URL (YouTube/Vimeo)</span>
              </label>
              <label class="flex items-center space-x-2 cursor-pointer">
                <input type="radio" name="hero_video_type" value="upload" x-model="videoType"
                       class="text-primary-600 focus:ring-primary-500">
                <span>Upload Video</span>
              </label>
            </div>

            <div x-show="videoType === 'url'" class="space-y-2">
              <x-forms.input name="hero_video" label="Video URL" :value="old('hero_video', $landingPage->hero_video_type === 'url' ? $landingPage->hero_video : '')"
                             :error="$errors->first('hero_video')" placeholder="https://www.youtube.com/watch?v=..." />
            </div>

            <div x-show="videoType === 'upload'" class="space-y-2">
              @if($landingPage->hero_video && $landingPage->hero_video_type === 'upload')
                <div class="mb-2 text-sm text-gray-600">Current video: <a href="{{ Storage::url($landingPage->hero_video) }}" target="_blank" class="text-primary-600">View</a></div>
              @endif
              <label class="block text-sm font-medium text-gray-700">Video File</label>
              <input type="file" name="hero_video_file" accept="video/mp4,video/quicktime"
                     class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
              <p class="text-xs text-gray-500">MP4 or MOV, max 50MB.</p>
              <x-forms.error :message="$errors->first('hero_video_file')" />
              @if($landingPage->hero_video)
                <div class="flex items-center gap-2 mt-2">
                  <input type="checkbox" name="hero_video_remove" id="hero_video_remove" value="1" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <label for="hero_video_remove" class="text-sm text-gray-700">Remove current video</label>
                </div>
              @endif
            </div>
          </div>
        </div>
      </x-card>

      <!-- Custom Content -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Custom Content</h2>
          <p class="text-sm text-gray-500">Add custom content to make your landing page unique</p>
        </div>

        <div class="space-y-6">
          <x-forms.rich-text name="custom_description" label="Custom Description" :value="old('custom_description', $landingPage->custom_description)"
                             height="400px" :error="$errors->first('custom_description')"
                             help="Rich text editor for detailed descriptions" />

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Custom Images</label>
            <p class="mb-3 text-xs text-gray-500">Upload multiple images to showcase your product</p>
            @if($landingPage->custom_images && count($landingPage->custom_images) > 0)
              <div class="mb-3 grid grid-cols-4 gap-2">
                @foreach($landingPage->custom_images as $image)
                  <div class="relative">
                    <img src="{{ Storage::url($image) }}" alt="" class="h-20 w-full rounded object-cover">
                    <input type="checkbox" name="remove_images[]" value="{{ $image }}" class="absolute top-1 right-1 h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                  </div>
                @endforeach
              </div>
            @endif
            <input type="file" name="custom_images[]" multiple accept="image/*"
                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            <x-forms.error :message="$errors->first('custom_images.*')" />
          </div>

          <div x-data="{ videoCount: {{ count(old('custom_videos', $landingPage->custom_videos ?? [])) > 0 ? count(old('custom_videos', $landingPage->custom_videos ?? [])) : 1 }}, videos: {{ json_encode(old('custom_videos', $landingPage->custom_videos ?? [])) }} }">
            <label class="block text-sm font-medium text-gray-700 mb-2">Custom Video URLs</label>
            <p class="mb-3 text-xs text-gray-500">Add YouTube or Vimeo video URLs</p>
            <div class="space-y-3" id="custom-videos-container">
              <template x-for="(video, index) in Array.from({length: videoCount}, (_, i) => i)" :key="index">
                <div class="flex gap-2">
                  <div class="flex-1">
                    <label :for="'custom_videos_' + index" class="block text-sm font-medium text-gray-700 mb-1" x-text="'Video URL ' + (index + 1)"></label>
                    <input type="text" :name="'custom_videos[]'" :id="'custom_videos_' + index"
                           :value="videos[index] || ''"
                           placeholder="https://www.youtube.com/watch?v=..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                  </div>
                  <button type="button" @click="videoCount--" class="mt-6 text-red-600 hover:text-red-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </template>
            </div>
            <button type="button" @click="videoCount++" class="mt-3 text-sm text-primary-600 hover:text-primary-800">
              + Add Another Video
            </button>
          </div>
        </div>
      </x-card>

      <!-- Call to Action -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">Call to Action</h2>
          <p class="text-sm text-gray-500">Configure the checkout button and CTA text</p>
        </div>

        <div class="space-y-6">
          <x-forms.textarea name="cta_text" label="CTA Text" :value="old('cta_text', $landingPage->cta_text)" rows="3"
                            :error="$errors->first('cta_text')"
                            placeholder="Compelling text to encourage action (e.g., 'Limited Time Offer!')" />
          <x-forms.input name="cta_button_text" label="Button Text" :value="old('cta_button_text', $landingPage->cta_button_text ?? 'Enroll Now')"
                         :error="$errors->first('cta_button_text')" placeholder="Enroll Now / Buy Now" />
        </div>
      </x-card>

      <!-- SEO Settings -->
      <x-card variant="elevated">
        <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
          <h2 class="text-lg font-medium text-gray-900">SEO Settings</h2>
          <p class="text-sm text-gray-500">Optimize your landing page for search engines</p>
        </div>

        <div class="space-y-6">
          <x-forms.input name="meta_title" label="Meta Title" :value="old('meta_title', $landingPage->meta_title)"
                         :error="$errors->first('meta_title')" placeholder="SEO title (50-60 characters)" />
          <x-forms.textarea name="meta_description" label="Meta Description" :value="old('meta_description', $landingPage->meta_description)" rows="3"
                            :error="$errors->first('meta_description')"
                            placeholder="SEO description (150-160 characters)" />
          <x-forms.image-uploader name="meta_image" label="Meta Image (OG Image)" :value="old('meta_image', $landingPage->meta_image ? Storage::url($landingPage->meta_image) : '')"
                                  accept="image/*" maxSize="2MB" :error="$errors->first('meta_image')"
                                  help="Image for social media sharing (1200x630px recommended)" />
          @if($landingPage->meta_image)
            <div class="flex items-center gap-2">
              <input type="checkbox" name="meta_image_remove" id="meta_image_remove" value="1" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <label for="meta_image_remove" class="text-sm text-gray-700">Remove current image</label>
            </div>
          @endif
        </div>
      </x-card>

      <!-- Submit Button -->
      <div class="flex items-center justify-end gap-4">
        <x-ui.link href="{{ route('admin.landing-pages.index') }}" variant="outline" size="md">
          Cancel
        </x-ui.link>
        <x-button type="submit" variant="primary" size="md">
          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Update Landing Page
        </x-button>
      </div>
    </form>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        // Auto-generate slug from title
        $('#landing-title').on('input', function() {
          const title = $(this).val();
          const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
          $('#landing-slug').val(slug);
        });

        // Dynamic product selection based on type
        const courses = @json($courses);
        const books = @json($books);

        $('#product-type').on('change', function() {
          const productType = $(this).val();
          const $productSelect = $('#product-id');
          $productSelect.empty();

          if (productType === 'course') {
            $productSelect.append('<option value="">Select a Course</option>');
            Object.keys(courses).forEach(function(id) {
              $productSelect.append('<option value="' + id + '">' + courses[id] + '</option>');
            });
          } else if (productType === 'book') {
            $productSelect.append('<option value="">Select a Book</option>');
            Object.keys(books).forEach(function(id) {
              $productSelect.append('<option value="' + id + '">' + books[id] + '</option>');
            });
          } else {
            $productSelect.append('<option value="">Select Product Type First</option>');
          }
        });

        // Set initial value
        @if(old('product_type', $landingPage->product_type))
          $('#product-type').trigger('change');
          $('#product-id').val('{{ old('product_id', $landingPage->product_id) }}');
        @endif
      });
    </script>
  @endpush
@endsection

