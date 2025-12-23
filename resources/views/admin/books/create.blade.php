@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Create New Book</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new book to the platform</p>
      </div>
      <x-ui.link href="{{ route('admin.books.index') }}" variant="default">
        ← Back to Books
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="title" label="Book Title" :value="old('title')" required :error="$errors->first('title')" id="book-title" />
          <x-forms.input name="slug" label="Slug" :value="old('slug')" required :error="$errors->first('slug')"
                         help="Auto-generated from title, or customize manually" id="book-slug" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="author" label="Author" :value="old('author')" required :error="$errors->first('author')" />
          <x-forms.input name="isbn" label="ISBN" :value="old('isbn')" :error="$errors->first('isbn')" />
        </div>

        <div>
          <x-forms.rich-text name="short_description" label="Short Description" :value="old('short_description')" height="200px"
                             :error="$errors->first('short_description')" />
        </div>

        <!-- Pricing & Stock Section - Super Simple -->
        <div class="rounded-lg border-2 border-primary-200 bg-primary-50 p-6">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Pricing & Stock</h3>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <x-forms.input name="price" label="Price (৳)" type="number" step="0.01" min="0"
                           :value="old('price')" required :error="$errors->first('price')" placeholder="0.00" />
            <x-forms.input name="discount" label="Discount (%)" type="number" step="0.01" min="0"
                           max="100" :value="old('discount', 0)" :error="$errors->first('discount')" placeholder="0" />
            <x-forms.input name="stock_quantity" label="Stock Quantity" type="number" min="0" :value="old('stock_quantity', 0)"
                           required :error="$errors->first('stock_quantity')" placeholder="0" />
          </div>
        </div>

        <div>
          <x-forms.tag-input name="tags" label="Tags" :value="old('tags')" :error="$errors->first('tags')"
                             help="Press Enter to add tags" />
        </div>


        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <!-- Files - Full Width -->
        <div class="space-y-6">
          <x-forms.image-uploader name="cover_image" label="Cover Image" :value="old('cover_image')" accept="image/*"
                                  maxSize="2MB" :error="$errors->first('cover_image')" />

          <!-- Preview Images Upload -->
          <div class="space-y-2" x-data="{ previewImages: [] }">
            <x-forms.label for="preview_images">Preview Images</x-forms.label>
            <p class="text-sm text-gray-500">Upload multiple images to showcase the book (2-5 images recommended)</p>

            <div class="mt-1">
              <label for="preview_images" class="cursor-pointer">
                <div
                     class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-6 transition-colors hover:border-primary-500 hover:bg-gray-50">
                  <div class="text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div class="mt-2 flex text-sm leading-6 text-gray-600">
                      <span class="relative font-semibold text-primary-600">Upload images</span>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB each</p>
                  </div>
                </div>
              </label>
              <input type="file" name="preview_images[]" id="preview_images" accept="image/*" multiple class="sr-only"
                     x-on:change="
                       previewImages = [];
                       Array.from($event.target.files).forEach(file => {
                         const reader = new FileReader();
                         reader.onload = (e) => {
                           previewImages.push({ name: file.name, url: e.target.result });
                         };
                         reader.readAsDataURL(file);
                       });
                     ">
            </div>

            <!-- Preview Images Display -->
            <div x-show="previewImages.length > 0" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
              <template x-for="(image, index) in previewImages" :key="index">
                <div class="group relative">
                  <img :src="image.url" :alt="image.name"
                       class="h-32 w-full rounded-lg border-2 border-gray-200 object-cover">
                  <div
                       class="absolute inset-0 flex items-center justify-center rounded-lg bg-black bg-opacity-50 opacity-0 transition-opacity group-hover:opacity-100">
                    <p class="px-2 text-center text-xs text-white" x-text="image.name"></p>
                  </div>
                </div>
              </template>
            </div>

            <x-forms.error :message="$errors->first('preview_images')" />
            <x-forms.error :message="$errors->first('preview_images.*')" />
            <x-forms.help message="These images will be displayed as a gallery for book preview" />
          </div>
        </div>

        <!-- Long Description - Full Width -->
        <div>
          <x-forms.rich-text name="long_description" label="Long Description" :value="old('long_description')" height="300px"
                             :error="$errors->first('long_description')" />
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.books.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Create Book
          </x-button>
        </div>
      </form>
    </x-card>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        const $titleInput = $('#book-title');
        const $slugInput = $('#book-slug');
        let isManualSlugEdit = false;

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
          isManualSlugEdit = true;
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
