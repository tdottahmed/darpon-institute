@php
  $index = $item['index'] ?? 0;
@endphp

<div class="pdf-preview-item rounded-lg border border-gray-200 bg-white p-4 shadow-sm" data-index="{{ $index }}">
  <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
    <h3 class="text-sm font-medium text-gray-900">
      PDF Preview <span class="item-number">{{ $loop->iteration ?? ($index + 1) }}</span>
    </h3>
    <button type="button" class="remove-item-btn rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">
      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
    </button>
  </div>

  <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <!-- Preview Image -->
    <div>
      <label class="mb-2 block text-sm font-medium text-gray-700">
        Preview Image <span class="text-red-500">*</span>
      </label>

      <!-- Image Preview -->
      @if(!empty($item['existing_image']))
        <div class="image-preview-container mb-3">
          <img src="{{ $item['existing_image'] }}" alt="Preview"
               class="preview-image h-32 w-full rounded-md border border-gray-300 object-cover">
        </div>
      @else
        <div class="image-preview-container mb-3" style="display: none;">
          <img src="" alt="Preview"
               class="preview-image h-32 w-full rounded-md border border-gray-300 object-cover">
        </div>
      @endif

      <!-- Image Upload -->
      <div class="space-y-2">
        <input type="file" name="pdf_preview_images[{{ $index }}]" accept="image/*"
               class="image-upload-input block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">

        <!-- Existing Image (for edit mode) -->
        <input type="hidden" name="pdf_preview_existing_images[{{ $index }}]"
               value="{{ $item['existing_image_path'] ?? '' }}">

        <!-- Image URL (alternative) -->
        <input type="url" name="pdf_preview_image_urls[{{ $index }}]"
               value="{{ $item['image_url'] ?? '' }}"
               placeholder="Or enter image URL"
               class="image-url-input block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
      </div>
    </div>

    <!-- PDF URL/File -->
    <div>
      <label class="mb-2 block text-sm font-medium text-gray-700">
        PDF File/URL <span class="text-red-500">*</span>
      </label>

      <!-- PDF File Upload -->
      <input type="file" name="pdf_preview_files[{{ $index }}]" accept=".pdf"
             class="mb-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">

      <!-- Existing PDF (for edit mode) -->
      <input type="hidden" name="pdf_preview_existing_files[{{ $index }}]"
             value="{{ $item['existing_pdf_path'] ?? '' }}">

      <!-- PDF URL (alternative) -->
      <input type="url" name="pdf_preview_urls[{{ $index }}]"
             value="{{ $item['pdf_url'] ?? '' }}"
             placeholder="Or enter PDF URL"
             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">

      <!-- Show existing PDF name if available -->
      @if(!empty($item['existing_pdf']))
        <div class="existing-pdf-name mt-2 text-xs text-gray-500">
          Current: <span>{{ basename($item['existing_pdf']) }}</span>
        </div>
      @endif
    </div>
  </div>

  <!-- Title -->
  <div class="mt-4">
    <label class="mb-2 block text-sm font-medium text-gray-700">
      Title (Optional)
    </label>
    <input type="text" name="pdf_preview_titles[{{ $index }}]"
           value="{{ $item['title'] ?? '' }}"
           placeholder="e.g., Chapter 1 Preview"
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
  </div>
</div>

