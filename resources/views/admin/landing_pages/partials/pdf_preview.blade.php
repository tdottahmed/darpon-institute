@php
  // Prepare PDF preview items for display
  $pdfPreviewItems = [];
  if (isset($landingPage) && $landingPage->pdf_previews) {
      foreach ($landingPage->pdf_previews as $index => $preview) {
          $image = $preview['image'] ?? '';
          $pdfUrl = $preview['pdf_url'] ?? '';

          // Handle existing image - check if it's a storage path or URL
        $existingImage = null;
        $existingImagePath = null;
        if ($image) {
            if (strpos($image, 'storage/') === 0) {
                $existingImage = asset('storage/' . str_replace('storage/', '', $image));
                $existingImagePath = $image;
            } elseif (strpos($image, 'http') === 0) {
                $existingImage = $image;
                $existingImagePath = null; // External URL, no path to store
            } else {
                $existingImage = asset('storage/' . $image);
                $existingImagePath = $image;
            }
        }

        // Handle existing PDF - extract path if it's a storage URL
          $existingPdf = null;
          $existingPdfPath = null;
          if ($pdfUrl) {
              if (strpos($pdfUrl, 'storage/') === 0) {
                  $existingPdf = asset('storage/' . str_replace('storage/', '', $pdfUrl));
                  $existingPdfPath = $pdfUrl;
              } elseif (strpos($pdfUrl, 'http') === 0) {
                  $existingPdf = $pdfUrl;
                  $existingPdfPath = null; // External URL, no path to store
              } else {
                  $existingPdf = asset('storage/' . $pdfUrl);
                  $existingPdfPath = $pdfUrl;
              }
          }

          $pdfPreviewItems[] = [
              'index' => $index,
              'title' => $preview['title'] ?? '',
              'image_url' => strpos($image ?? '', 'http') === 0 ? $image : '',
              'pdf_url' => strpos($pdfUrl ?? '', 'http') === 0 ? $pdfUrl : '',
              'existing_image' => $existingImage,
              'existing_image_path' => $existingImagePath,
              'existing_pdf' => $existingPdf,
              'existing_pdf_path' => $existingPdfPath,
          ];
      }
  }

  // Determine form action and method
  $formAction = isset($landingPage)
      ? route('admin.landing-pages.update-partial', $landingPage)
      : route('admin.landing-pages.store-partial');
  $formMethod = isset($landingPage) ? 'PUT' : 'POST';
@endphp

<!-- PDF Preview Tab -->
<div class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">PDF Preview Section</h2>
      <p class="text-sm text-gray-500">Add multiple PDF preview cards with images and links</p>
    </div>

    <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" id="pdfPreviewForm">
      @csrf
      @if (isset($landingPage))
        @method('PUT')
        <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
      @endif
      <input type="hidden" name="tab" value="pdf">

      <div class="space-y-6">
        <!-- PDF Preview Items Container -->
        <div id="pdfPreviewItems" class="space-y-4">
          @foreach ($pdfPreviewItems as $item)
            @include('admin.landing_pages.partials.pdf_preview_item', [
                'index' => $item['index'],
                'item' => $item,
            ])
          @endforeach
        </div>

        <!-- Add New PDF Preview Button -->
        <button type="button" id="addPdfPreviewBtn"
                class="flex w-full items-center justify-center rounded-md border-2 border-dashed border-gray-300 bg-white px-4 py-6 text-sm font-medium text-gray-700 hover:border-primary-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
          <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Add PDF Preview
        </button>

        <!-- Help Text -->
        <div class="rounded-md bg-blue-50 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-blue-800">Instructions</h3>
              <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc space-y-1 pl-5">
                  <li>Upload a preview image or provide an image URL</li>
                  <li>Upload a PDF file or provide a PDF URL</li>
                  <li>Title is optional but recommended for better organization</li>
                  <li>You can add multiple PDF previews</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <x-forms.error :message="$errors->first('pdf_previews')" />

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=pdf"
             class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
            Cancel
          </a>
          <x-button type="submit" variant="primary" size="md">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ isset($landingPage) ? 'Update PDF Preview' : 'Save PDF Preview' }}
          </x-button>
        </div>
      </div>
    </form>
  </x-card>
</div>

@push('scripts')
  <script>
    $(document).ready(function() {
      let itemIndex = {{ count($pdfPreviewItems) }};

      // Add new PDF preview item
      $('#addPdfPreviewBtn').on('click', function() {
        const newItemHtml = `
          <div class="pdf-preview-item rounded-lg border border-gray-200 bg-white p-4 shadow-sm" data-index="${itemIndex}">
            <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-3">
              <h3 class="text-sm font-medium text-gray-900">
                PDF Preview <span class="item-number">${itemIndex + 1}</span>
              </h3>
              <button type="button" class="remove-item-btn rounded-md text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Preview Image -->
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                  Preview Image <span class="text-red-500">*</span>
                </label>
                <div class="image-preview-container mb-3" style="display: none;">
                  <img src="" alt="Preview" class="preview-image h-32 w-full rounded-md border border-gray-300 object-cover">
                </div>
                <div class="space-y-2">
                  <input type="file" name="pdf_preview_images[${itemIndex}]" accept="image/*" class="image-upload-input block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">
                  <input type="hidden" name="pdf_preview_existing_images[${itemIndex}]" value="">
                  <input type="url" name="pdf_preview_image_urls[${itemIndex}]" placeholder="Or enter image URL" class="image-url-input block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
              </div>

              <!-- PDF URL/File -->
              <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                  PDF File/URL <span class="text-red-500">*</span>
                </label>
                <input type="file" name="pdf_preview_files[${itemIndex}]" accept=".pdf" class="mb-2 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">
                <input type="hidden" name="pdf_preview_existing_files[${itemIndex}]" value="">
                <input type="url" name="pdf_preview_urls[${itemIndex}]" placeholder="Or enter PDF URL" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <div class="existing-pdf-name mt-2 text-xs text-gray-500" style="display: none;">
                  Current: <span></span>
                </div>
              </div>
            </div>

            <!-- Title -->
            <div class="mt-4">
              <label class="mb-2 block text-sm font-medium text-gray-700">
                Title (Optional)
              </label>
              <input type="text" name="pdf_preview_titles[${itemIndex}]" placeholder="e.g., Chapter 1 Preview" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
            </div>
          </div>
        `;

        $('#pdfPreviewItems').append(newItemHtml);
        itemIndex++;

        // Update item numbers
        updateItemNumbers();
      });

      // Remove PDF preview item
      $(document).on('click', '.remove-item-btn', function() {
        if (confirm('Are you sure you want to remove this PDF preview?')) {
          $(this).closest('.pdf-preview-item').remove();
          updateItemNumbers();
        }
      });

      // Preview image on file selection
      $(document).on('change', '.image-upload-input', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const container = $(this).siblings('.image-preview-container');
            container.find('.preview-image').attr('src', e.target.result);
            container.show();
          }.bind(this);
          reader.readAsDataURL(file);
        }
      });

      // Update item numbers
      function updateItemNumbers() {
        $('.pdf-preview-item').each(function(index) {
          $(this).find('.item-number').text(index + 1);
        });
      }
    });
  </script>
@endpush
