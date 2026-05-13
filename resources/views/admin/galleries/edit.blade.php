@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Gallery Image</h1>
        <p class="mt-1 text-sm text-gray-600">Update title (alt text), optional new image, order, and status</p>
      </div>
      <x-ui.link href="{{ route('admin.galleries.index') }}" variant="default">
        ← Back to Gallery
      </x-ui.link>
    </div>

    <x-card variant="elevated">
      <form id="gallery-edit-form" action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6" novalidate>
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-gray-200 bg-gray-50/80 p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800/50 sm:p-5">
          <div class="mb-4">
            <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Current image</h2>
            <div class="mt-2 overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-900">
              <img id="gallery-current-img" src="{{ Storage::url($gallery->image) }}"
                   alt="{{ $gallery->title ?: 'Gallery image' }}"
                   class="max-h-64 w-full object-contain">
            </div>
          </div>

          <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <div class="space-y-2">
              <x-forms.label for="title" :required="true">Title (alt text)</x-forms.label>
              <input type="text" id="title" name="title" value="{{ old('title', $gallery->title) }}" maxlength="255" required
                     data-field="title"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                     placeholder="Describe the image for accessibility">
              <p id="error-title" class="hidden text-sm text-red-600" role="alert"></p>
              @error('title')
                <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div class="space-y-2">
              <x-forms.label for="image">Replace image</x-forms.label>
              <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/png,image/gif"
                     data-field="image"
                     class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-primary-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-700 dark:text-gray-300">
              <p class="text-xs text-gray-500">Leave empty to keep the current file. JPG, JPEG, PNG, or GIF — max 5MB</p>
              <p id="error-image" class="hidden text-sm text-red-600" role="alert"></p>
              @error('image')
                <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div id="gallery-new-preview" class="mt-4 hidden overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-900">
            <p class="border-b border-gray-100 px-3 py-2 text-xs font-medium text-gray-600 dark:border-gray-700 dark:text-gray-300">New image preview</p>
            <img id="gallery-new-preview-img" src="" alt="" class="max-h-56 w-full object-contain" loading="lazy">
          </div>

          <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="space-y-2">
              <x-forms.label for="order">Display order</x-forms.label>
              <input type="number" id="order" name="order" min="0" value="{{ old('order', $gallery->order) }}"
                     class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white">
              @error('order')
                <p class="text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <div class="flex items-center space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', $gallery->status) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-200">Active Status</label>
        </div>

        <p id="gallery-form-error" class="hidden text-sm font-medium text-red-600" role="alert"></p>

        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end sm:gap-4 dark:border-gray-700">
          <x-ui.link href="{{ route('admin.galleries.index') }}" variant="outline" size="md">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Save changes
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection

@push('scripts')
  <script>
    (function ($) {
      'use strict';
      var MAX_BYTES = 5 * 1024 * 1024;
      var ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'gif'];

      function extOf(filename) {
        var p = (filename || '').lastIndexOf('.');
        return p === -1 ? '' : filename.slice(p + 1).toLowerCase();
      }

      function validateImageFile(file) {
        if (!file || !file.size) return '';
        if (file.size > MAX_BYTES) return 'Image must be 5MB or smaller.';
        if (ALLOWED_EXT.indexOf(extOf(file.name)) === -1) return 'Use JPG, JPEG, PNG, or GIF only.';
        return '';
      }

      $(function () {
        var $form = $('#gallery-edit-form');
        var $file = $('#image');
        var $newWrap = $('#gallery-new-preview');
        var $newImg = $('#gallery-new-preview-img');
        var $title = $('#title');

        $file.on('change', function () {
          $('#error-image').addClass('hidden').text('');
          var f = this.files && this.files[0];
          var err = f ? validateImageFile(f) : '';
          if (err) {
            $('#error-image').removeClass('hidden').text(err);
            $newWrap.addClass('hidden');
            $newImg.attr('src', '').attr('alt', '');
            return;
          }
          if (!f) {
            $newWrap.addClass('hidden');
            $newImg.attr('src', '').attr('alt', '');
            return;
          }
          var reader = new FileReader();
          reader.onload = function (e) {
            var t = $.trim($title.val() || '');
            $newImg.attr('src', e.target.result).attr('alt', t || 'Preview');
            $newWrap.removeClass('hidden');
          };
          reader.readAsDataURL(f);
        });

        $title.on('input', function () {
          var t = $.trim($(this).val() || '');
          if ($newImg.attr('src') && $newImg.attr('src').indexOf('data:') === 0) {
            $newImg.attr('alt', t || 'Preview');
          }
        });

        $form.on('submit', function (e) {
          $('#gallery-form-error').addClass('hidden').text('');
          $('#error-title').addClass('hidden').text('');
          $('#error-image').addClass('hidden').text('');
          var ok = true;
          if (!$.trim($title.val())) {
            $('#error-title').removeClass('hidden').text('Title is required.');
            ok = false;
          }
          var f = $file[0].files && $file[0].files[0];
          if (f) {
            var ie = validateImageFile(f);
            if (ie) {
              $('#error-image').removeClass('hidden').text(ie);
              ok = false;
            }
          }
          if (!ok) {
            e.preventDefault();
            $('#gallery-form-error').removeClass('hidden').text('Please fix the errors below before saving.');
          }
        });
      });
    })(jQuery);
  </script>
@endpush
