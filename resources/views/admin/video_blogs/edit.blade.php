@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Video Blog</h1>
        <p class="mt-1 text-sm text-gray-600">Edit video blog details</p>
      </div>
      <x-ui.link href="{{ route('admin.video-blogs.index') }}" variant="default">
        ← Back to Video Blogs
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.video-blogs.update', $videoBlog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="title" label="Title" :value="old('title', $videoBlog->title)" required :error="$errors->first('title')" id="blog-title" />
          <x-forms.input name="slug" label="Slug" :value="old('slug', $videoBlog->slug)" required :error="$errors->first('slug')"
                         help="Auto-generated from title, or customize manually" id="blog-slug" />
        </div>

        <div>
          <x-forms.rich-text name="short_description" label="Short Description" :value="old('short_description', $videoBlog->short_description)" height="150px"
                             :error="$errors->first('short_description')" />
        </div>

        <!-- Video Source Selection -->
        <div x-data="{ videoType: '{{ old('video_type', $videoBlog->video_type) }}' }" class="rounded-lg border-2 border-primary-200 bg-primary-50 p-6">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Video Source</h3>
          
          <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Video Type</label>
              <div class="flex space-x-4">
                  <label class="flex items-center space-x-2 cursor-pointer">
                      <input type="radio" name="video_type" value="upload" x-model="videoType" class="text-primary-600 focus:ring-primary-500">
                      <span>Upload Video</span>
                  </label>
                  <label class="flex items-center space-x-2 cursor-pointer">
                      <input type="radio" name="video_type" value="youtube" x-model="videoType" class="text-primary-600 focus:ring-primary-500">
                      <span>YouTube Link</span>
                  </label>
              </div>
          </div>

          <!-- Upload Field -->
          <div x-show="videoType === 'upload'" class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">Video File</label>
              @if($videoBlog->video_type === 'upload' && $videoBlog->video_file)
                  <p class="text-sm text-gray-600 mb-2">Current file: <a href="{{ Storage::url($videoBlog->video_file) }}" target="_blank" class="text-primary-600 hover:underline">View Video</a></p>
              @endif
              <input type="file" name="video_file" accept="video/mp4,video/quicktime" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
              <p class="text-xs text-gray-500">MP4 or MOV, max 50MB. Leave empty to keep existing.</p>
              <x-forms.error :message="$errors->first('video_file')" />
          </div>

          <!-- YouTube Field -->
          <div x-show="videoType === 'youtube'" class="space-y-2">
              <x-forms.input name="video_url" label="YouTube URL" placeholder="https://www.youtube.com/watch?v=..." :value="old('video_url', $videoBlog->video_url)" ::required="videoType === 'youtube'" :error="$errors->first('video_url')" />
          </div>
        </div>

        <div>
            @php
                $tags = $videoBlog->tags;
                if (is_array($tags)) {
                    $tags = implode(',', $tags);
                }
            @endphp
          <x-forms.tag-input name="tags" label="Tags" :value="old('tags', $tags)" :error="$errors->first('tags')"
                             help="Press Enter to add tags" />
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', $videoBlog->status) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <!-- Thumbnail -->
        <div class="space-y-6">
          <x-forms.image-uploader name="thumbnail" label="Thumbnail Image" :value="old('thumbnail')" 
                                  :preview="$videoBlog->thumbnail ? Storage::url($videoBlog->thumbnail) : null"
                                  accept="image/*"
                                  maxSize="2MB" :error="$errors->first('thumbnail')" />
        </div>

        <!-- Long Description -->
        <div>
          <x-forms.rich-text name="long_description" label="Long Description" :value="old('long_description', $videoBlog->long_description)" height="300px"
                             :error="$errors->first('long_description')" />
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.video-blogs.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update Video Blog
          </x-button>
        </div>
      </form>
    </x-card>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        const $titleInput = $('#blog-title');
        const $slugInput = $('#blog-slug');
        let isManualSlugEdit = false;

        function generateSlug(text) {
          return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
        }

        $titleInput.on('input', function() {
          if (!isManualSlugEdit) {
            $slugInput.val(generateSlug($(this).val()));
          }
        });

        $slugInput.on('input', function() {
          isManualSlugEdit = true;
        });

        // Only auto-update if it hasn't been manually changed, 
        // unlike create, we might not want to aggressively overwrite on edit unless user clears it
        $slugInput.on('blur', function() {
          const autoSlug = generateSlug($titleInput.val());
          if ($(this).val() === autoSlug) {
            isManualSlugEdit = false;
          }
        });
      });
    </script>
  @endpush
@endsection
