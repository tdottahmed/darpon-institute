@extends('layouts.admin')

@php
  $imagesOld = old('images');
  if (! is_array($imagesOld) || count($imagesOld) < 1) {
      $imagesOld = [['title' => '']];
  }
  $nextJsIndex = (int) max(array_keys($imagesOld)) + 1;
@endphp

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Upload Gallery Images</h1>
        <p class="mt-1 text-sm text-gray-600">Add gallery items with a title (used as image alt text) and one image each</p>
      </div>
      <x-ui.link href="{{ route('admin.galleries.index') }}" variant="default">
        ← Back to Gallery
      </x-ui.link>
    </div>

    <x-card variant="elevated">
      <form id="gallery-upload-form" action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6" novalidate>
        @csrf

        @error('images')
          <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $message }}
          </div>
        @enderror

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
          <div>
            <h2 class="text-base font-semibold text-gray-900">Gallery items</h2>
            <p class="text-sm text-gray-500">JPG, JPEG, PNG, or GIF — max 5MB per image. Title is required and becomes the alt attribute on the site.</p>
          </div>
          <button type="button" id="gallery-add-row"
                  class="inline-flex items-center justify-center gap-2 rounded-lg border border-primary-600 bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New
          </button>
        </div>

        <div id="gallery-items" class="space-y-4">
          @foreach ($imagesOld as $index => $row)
            @php
              $title = is_array($row) ? ($row['title'] ?? '') : '';
            @endphp
            <div class="gallery-item-card rounded-xl border border-gray-200 bg-gray-50/80 p-4 shadow-sm transition hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800/50 dark:hover:border-gray-600 sm:p-5"
                 data-gallery-item>
              <div class="mb-4 flex items-start justify-between gap-3">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Gallery Item</h3>
                <button type="button"
                        class="gallery-remove-row inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:border-red-900/40 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30"
                        title="Remove this item">
                  Remove
                </button>
              </div>

              <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                <div class="space-y-2">
                  <x-forms.label for="gallery-title-{{ $index }}" :required="true">Title (alt text)</x-forms.label>
                  <input type="text" id="gallery-title-{{ $index }}" name="images[{{ $index }}][title]" value="{{ $title }}"
                         maxlength="255" autocomplete="off" data-field="title"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                         placeholder="Describe the image for accessibility">
                  <p class="gallery-field-error text-sm text-red-600" data-error-for="title" role="alert" hidden></p>
                  @error("images.$index.title")
                    <p class="text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>

                <div class="space-y-2">
                  <x-forms.label for="gallery-image-{{ $index }}" :required="true">Image</x-forms.label>
                  <input type="file" id="gallery-image-{{ $index }}" name="images[{{ $index }}][image]" accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/png,image/gif"
                         data-field="image"
                         class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-primary-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-700 dark:text-gray-300">
                  <p class="text-xs text-gray-500">Accepted: JPG, JPEG, PNG, GIF — max 5MB</p>
                  <p class="gallery-field-error text-sm text-red-600" data-error-for="image" role="alert" hidden></p>
                  @error("images.$index.image")
                    <p class="text-sm text-red-600">{{ $message }}</p>
                  @enderror
                </div>
              </div>

              <div class="gallery-preview mt-4 hidden overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-900"
                   data-preview-wrap>
                <img src="" alt="" class="gallery-preview-img max-h-56 w-full object-contain" data-preview-img loading="lazy">
              </div>
            </div>
          @endforeach
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-200">Active Status</label>
        </div>

        <p id="gallery-form-error" class="hidden text-sm font-medium text-red-600" role="alert"></p>

        <!-- Submit Buttons -->
        <div class="flex flex-col-reverse items-stretch gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end sm:gap-4 dark:border-gray-700">
          <x-ui.link href="{{ route('admin.galleries.index') }}" variant="outline" size="md">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Upload Images
          </x-button>
        </div>
      </form>
    </x-card>
  </div>

  <template id="gallery-row-template">
    <div class="gallery-item-card rounded-xl border border-gray-200 bg-gray-50/80 p-4 shadow-sm transition hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800/50 dark:hover:border-gray-600 sm:p-5"
         data-gallery-item>
      <div class="mb-4 flex items-start justify-between gap-3">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Gallery Item</h3>
        <button type="button"
                class="gallery-remove-row inline-flex items-center rounded-lg border border-red-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:border-red-900/40 dark:bg-gray-900 dark:text-red-400 dark:hover:bg-red-950/30"
                title="Remove this item">
          Remove
        </button>
      </div>
      <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="gallery-title-__INDEX__">Title (alt text) <span class="text-red-500">*</span></label>
          <input type="text" id="gallery-title-__INDEX__" name="images[__INDEX__][title]" value="" maxlength="255" autocomplete="off" data-field="title"
                 class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                 placeholder="Describe the image for accessibility">
          <p class="gallery-field-error text-sm text-red-600" data-error-for="title" role="alert" hidden></p>
        </div>
        <div class="space-y-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200" for="gallery-image-__INDEX__">Image <span class="text-red-500">*</span></label>
          <input type="file" id="gallery-image-__INDEX__" name="images[__INDEX__][image]" accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/png,image/gif"
                 data-field="image"
                 class="block w-full text-sm text-gray-600 file:mr-4 file:rounded-md file:border-0 file:bg-primary-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary-700 dark:text-gray-300">
          <p class="text-xs text-gray-500">Accepted: JPG, JPEG, PNG, GIF — max 5MB</p>
          <p class="gallery-field-error text-sm text-red-600" data-error-for="image" role="alert" hidden></p>
        </div>
      </div>
      <div class="gallery-preview mt-4 hidden overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-600 dark:bg-gray-900"
           data-preview-wrap>
        <img src="" alt="" class="gallery-preview-img max-h-56 w-full object-contain" data-preview-img loading="lazy">
      </div>
    </div>
  </template>
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

      function setFieldError($card, field, message) {
        var $e = $card.find('[data-error-for="' + field + '"]');
        if (message) {
          $e.text(message).removeAttr('hidden');
        } else {
          $e.text('').attr('hidden', 'hidden');
        }
      }

      function clearCardErrors($card) {
        setFieldError($card, 'title', '');
        setFieldError($card, 'image', '');
      }

      function showPreview($card, file) {
        var $wrap = $card.find('[data-preview-wrap]');
        var $img = $card.find('[data-preview-img]');
        if (!file || !file.type || file.type.indexOf('image/') !== 0) {
          $wrap.addClass('hidden');
          $img.attr('src', '').attr('alt', '');
          return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
          var title = $.trim($card.find('[data-field="title"]').val() || '');
          $img.attr('src', e.target.result).attr('alt', title || 'Preview');
          $wrap.removeClass('hidden');
        };
        reader.readAsDataURL(file);
      }

      function validateImageFile(file) {
        if (!file || !file.size) {
          return 'Image is required.';
        }
        if (file.size > MAX_BYTES) {
          return 'Image must be 5MB or smaller.';
        }
        var ext = extOf(file.name);
        if (ALLOWED_EXT.indexOf(ext) === -1) {
          return 'Use JPG, JPEG, PNG, or GIF only.';
        }
        return '';
      }

      function validateTitle(val) {
        if (!$.trim(val)) {
          return 'Title is required.';
        }
        return '';
      }

      function updateRemoveButtons() {
        var $items = $('[data-gallery-item]');
        var onlyOne = $items.length <= 1;
        $items.find('.gallery-remove-row').prop('disabled', onlyOne).toggleClass('opacity-50 cursor-not-allowed', onlyOne);
      }

      function bindRow($card) {
        $card.find('[data-field="image"]').on('change', function () {
          var f = this.files && this.files[0];
          setFieldError($card, 'image', f ? validateImageFile(f) : '');
          if (f && !validateImageFile(f)) {
            showPreview($card, f);
          } else if (!f) {
            showPreview($card, null);
          }
        });
        $card.find('[data-field="title"]').on('input blur', function () {
          setFieldError($card, 'title', validateTitle($(this).val()));
          var f = $card.find('[data-field="image"]')[0].files[0];
          if (f && $card.find('[data-preview-wrap]').is(':visible')) {
            $card.find('[data-preview-img]').attr('alt', $.trim($(this).val()) || 'Preview');
          }
        });
      }

      $(function () {
        var nextIndex = {{ $nextJsIndex }};

        $('[data-gallery-item]').each(function () {
          bindRow($(this));
        });
        updateRemoveButtons();

        $('#gallery-add-row').on('click', function () {
          var tpl = document.getElementById('gallery-row-template');
          var raw = tpl ? tpl.innerHTML : '';
          var html = raw.replace(/__INDEX__/g, String(nextIndex));
          nextIndex++;
          var $node = $(html);
          $('#gallery-items').append($node);
          bindRow($node);
          updateRemoveButtons();
          $node.hide().slideDown(180);
        });

        $('#gallery-items').on('click', '.gallery-remove-row', function () {
          if ($(this).prop('disabled')) return;
          var $card = $(this).closest('[data-gallery-item]');
          if ($('[data-gallery-item]').length <= 1) return;
          $card.slideUp(180, function () {
            $card.remove();
            updateRemoveButtons();
          });
        });

        $('#gallery-upload-form').on('submit', function (e) {
          var $form = $(this);
          var ok = true;
          $('#gallery-form-error').addClass('hidden').text('');
          $('[data-gallery-item]').each(function () {
            var $card = $(this);
            clearCardErrors($card);
            var title = $card.find('[data-field="title"]').val();
            var fileInput = $card.find('[data-field="image"]')[0];
            var file = fileInput.files && fileInput.files[0];
            var te = validateTitle(title);
            var ie = validateImageFile(file);
            if (te) {
              setFieldError($card, 'title', te);
              ok = false;
            }
            if (ie) {
              setFieldError($card, 'image', ie);
              ok = false;
            }
          });
          if (!ok) {
            e.preventDefault();
            $('#gallery-form-error').removeClass('hidden').text('Please fix the errors below before uploading.');
            var $firstErr = $('.gallery-field-error:visible').first();
            if ($firstErr.length) {
              $('html, body').animate({ scrollTop: Math.max(0, $firstErr.offset().top - 120) }, 280);
            }
          }
        });
      });
    })(jQuery);
  </script>
@endpush
