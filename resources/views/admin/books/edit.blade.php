@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Book</h1>
        <p class="mt-1 text-sm text-gray-600">Update book details</p>
      </div>
      <x-ui.link href="{{ route('admin.books.index') }}" variant="default">
        ← Back to Books
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="title" label="Book Title" :value="old('title', $book->title)" required :error="$errors->first('title')" id="book-title" />
          <x-forms.input name="slug" label="Slug" :value="old('slug', $book->slug)" required :error="$errors->first('slug')"
                         help="Auto-generated from title, or customize manually" id="book-slug" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="author" label="Author" :value="old('author', $book->author)" required :error="$errors->first('author')" />
          <x-forms.input name="isbn" label="ISBN" :value="old('isbn', $book->isbn)" :error="$errors->first('isbn')" />
        </div>

        <div>
          <x-forms.rich-text name="short_description" label="Short Description" :value="old('short_description', $book->short_description)" height="200px"
                             :error="$errors->first('short_description')" />
        </div>

        <!-- Pricing & Stock Section - Super Simple -->
        <div class="rounded-lg border-2 border-primary-200 bg-primary-50 p-6">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Pricing & Stock</h3>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <x-forms.input name="price" label="Price (৳)" type="number" step="0.01" min="0"
                           :value="old('price', $book->price)" required :error="$errors->first('price')" placeholder="0.00" />
            <x-forms.input name="discount" label="Discount (%)" type="number" step="0.01" min="0"
                           max="100" :value="old('discount', $book->discount ?? 0)" :error="$errors->first('discount')" placeholder="0" />
            <x-forms.input name="stock_quantity" label="Stock Quantity" type="number" min="0" :value="old('stock_quantity', $book->stock_quantity ?? 0)"
                           required :error="$errors->first('stock_quantity')" placeholder="0" />
          </div>
          @if ($book->discount > 0 && $book->price)
            <div class="mt-4 rounded-lg bg-white p-3">
              <p class="text-sm text-gray-600">Original Price: <span
                      class="font-medium line-through">{{ format_price($book->price) }}</span></p>
              <p class="text-lg font-bold text-primary-600">Discounted Price:
                {{ format_price($book->discounted_price) }}</p>
            </div>
          @endif
        </div>

        <div>
          <x-forms.tag-input name="tags" label="Tags" :value="old(
              'tags',
              is_array($book->tags)
                  ? $book->tags
                  : (is_string($book->tags) && $book->tags
                      ? explode(',', $book->tags)
                      : []),
          )" :error="$errors->first('tags')"
                             help="Press Enter to add tags" />
        </div>


        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1"
                 {{ old('status', $book->status) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <!-- Files - Full Width -->
        <div class="space-y-6">
          <x-forms.image-uploader name="cover_image" label="Cover Image" :value="old('cover_image', $book->cover_image ? asset('storage/' . $book->cover_image) : '')" accept="image/*"
                                  maxSize="2MB" :error="$errors->first('cover_image')" />

          <!-- Preview Images Upload -->
          <div class="space-y-2" x-data="{ newImages: [] }">
            <x-forms.label for="preview_images">Preview Images</x-forms.label>
            <p class="text-sm text-gray-500">Upload multiple images to showcase the book (2-5 images recommended)</p>

            <!-- Existing Preview Images -->
            @if ($book->preview_images && is_array($book->preview_images) && count($book->preview_images) > 0)
              <div class="mt-2">
                <p class="mb-2 text-sm font-medium text-gray-700">Current Preview Images:</p>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4" id="existing-preview-images">
                  @foreach ($book->preview_images as $index => $previewImage)
                    <div class="existing-preview-image group relative">
                      <img src="{{ Storage::url($previewImage) }}" alt="Preview"
                           class="h-32 w-full rounded-lg border-2 border-gray-200 object-cover">
                      <button type="button" onclick="this.closest('.existing-preview-image').remove();"
                              class="absolute -right-2 -top-2 rounded-full bg-red-600 p-1.5 text-white opacity-0 transition-opacity hover:bg-red-700 group-hover:opacity-100">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                      <input type="hidden" name="existing_preview_images[]" value="{{ Storage::url($previewImage) }}">
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <div class="mt-4">
              <label for="preview_images" class="cursor-pointer">
                <div
                     class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-6 transition-colors hover:border-primary-500 hover:bg-gray-50">
                  <div class="text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div class="mt-2 flex text-sm leading-6 text-gray-600">
                      <span class="relative font-semibold text-primary-600">Upload new images</span>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 2MB each</p>
                  </div>
                </div>
              </label>
              <input type="file" name="preview_images[]" id="preview_images" accept="image/*" multiple
                     class="sr-only"
                     x-on:change="
                       newImages = [];
                       Array.from($event.target.files).forEach(file => {
                         const reader = new FileReader();
                         reader.onload = (e) => {
                           newImages.push({ name: file.name, url: e.target.result });
                         };
                         reader.readAsDataURL(file);
                       });
                     ">
            </div>

            <!-- New Preview Images Display -->
            <div x-show="newImages.length > 0" class="mt-4">
              <p class="mb-2 text-sm font-medium text-gray-700">New Preview Images:</p>
              <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                <template x-for="(image, index) in newImages" :key="index">
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
            </div>

            <x-forms.error :message="$errors->first('preview_images')" />
            <x-forms.error :message="$errors->first('preview_images.*')" />
            <x-forms.help message="These images will be displayed as a gallery for book preview" />
          </div>
        </div>

        <!-- Long Description - Full Width -->
        <div>
          <x-forms.rich-text name="long_description" label="Long Description" :value="old('long_description', $book->long_description)" height="400px"
                             :error="$errors->first('long_description')" />
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.books.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update Book
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
