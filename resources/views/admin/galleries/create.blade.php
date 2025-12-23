@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Upload Gallery Images</h1>
        <p class="mt-1 text-sm text-gray-600">Upload one or multiple images to the gallery</p>
      </div>
      <x-ui.link href="{{ route('admin.galleries.index') }}" variant="default">
        ← Back to Gallery
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Image Upload -->
        <div class="space-y-2" x-data="{ previewImages: [], files: [] }">
          <x-forms.label for="images">Gallery Images</x-forms.label>
          <p class="text-sm text-gray-500">You can upload multiple images at once (max 5MB per image)</p>

          <div class="mt-1">
            <label for="images" class="cursor-pointer">
              <div
                   class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-12 transition-colors hover:border-primary-500 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800">
                <div class="text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <span class="relative font-semibold text-primary-600">Upload images</span>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 5MB each</p>
                </div>
              </div>
            </label>
            <input type="file" name="images[]" id="images" accept="image/*" multiple class="sr-only"
                   x-on:change="
                     previewImages = [];
                     files = Array.from($event.target.files);
                     files.forEach(file => {
                       const reader = new FileReader();
                       reader.onload = (e) => {
                         previewImages.push({ name: file.name, url: e.target.result });
                       };
                       reader.readAsDataURL(file);
                     });
                   " />
          </div>

          <!-- Preview -->
          <div x-show="previewImages.length > 0" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            <template x-for="(preview, index) in previewImages" :key="index">
              <div class="group relative">
                <img :src="preview.url" :alt="preview.name"
                     class="h-32 w-full rounded-lg border border-gray-300 object-cover">
                <div
                     class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/50 opacity-0 transition-opacity group-hover:opacity-100">
                  <span class="text-xs font-medium text-white" x-text="preview.name"></span>
                </div>
              </div>
            </template>
          </div>

          @error('images')
            <p class="text-sm text-red-600">{{ $message }}</p>
          @enderror
          @error('images.*')
            <p class="text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
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
@endsection
