@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Course</h1>
        <p class="mt-1 text-sm text-gray-600">Update course details</p>
      </div>
      <x-ui.link href="{{ route('admin.courses.index') }}" variant="default">
        ← Back to Courses
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="title" label="Course Title" :value="old('title', $course->title)" required :error="$errors->first('title')"
                         id="course-title" />
          <x-forms.input name="slug" label="Slug" :value="old('slug', $course->slug)" required :error="$errors->first('slug')"
                         help="Auto-generated from title, or customize manually" id="course-slug" />
        </div>

        <div>
          <x-forms.rich-text name="short_description" label="Short Description" :value="old('short_description', $course->short_description)" height="200px"
                             :error="$errors->first('short_description')" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="duration" label="Duration" :value="old('duration', $course->duration)" placeholder="e.g. 10h 30m"
                         :error="$errors->first('duration')" />
          <x-forms.tag-input name="tags" label="Tags" :value="old(
              'tags',
              is_array($course->tags)
                  ? $course->tags
                  : (is_string($course->tags) && $course->tags
                      ? explode(',', $course->tags)
                      : []),
          )" :error="$errors->first('tags')"
                             help="Press Enter to add tags" />
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1"
                 {{ old('status', $course->status) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <!-- Files - Full Width -->
        <div class="space-y-6">
          <x-forms.image-uploader name="thumbnail" label="Thumbnail" :value="old('thumbnail', $course->thumbnail ? asset('storage/' . $course->thumbnail) : '')" accept="image/*" maxSize="2MB"
                                  :error="$errors->first('thumbnail')" />
          <x-forms.video-uploader name="preview_video" label="Preview Video" :value="old('preview_video', $course->preview_video ? asset('storage/' . $course->preview_video) : '')"
                                  accept="video/mp4,video/quicktime" maxSize="50MB" :error="$errors->first('preview_video')" />
        </div>

        <!-- Long Description - Full Width -->
        <div>
          <x-forms.rich-text name="long_description" label="Long Description" :value="old('long_description', $course->long_description)" height="400px"
                             :error="$errors->first('long_description')" />
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.courses.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update Course
          </x-button>
        </div>
      </form>
    </x-card>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        const $titleInput = $('#course-title');
        const $slugInput = $('#course-slug');
        let isManualSlugEdit = false;
        const originalSlug = $slugInput.val();

        // Generate slug from title
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

        // Auto-generate slug when title changes
        $titleInput.on('input', function() {
          if (!isManualSlugEdit) {
            $slugInput.val(generateSlug($(this).val()));
          }
        });

        // Track manual slug edits
        $slugInput.on('input', function() {
          if ($(this).val() !== originalSlug) {
            isManualSlugEdit = true;
          }
        });

        // Reset manual edit flag when slug matches auto-generated
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
