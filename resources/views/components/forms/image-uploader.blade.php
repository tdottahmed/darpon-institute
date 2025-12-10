@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'error' => null,
    'help' => null,
    'accept' => 'image/*',
    'maxSize' => '5MB',
])

<div class="space-y-1" x-data="{ imagePreview: '{{ $value }}', fileName: '' }">
  @if ($label)
    <x-forms.label :for="$name" :required="$required">{{ $label }}</x-forms.label>
  @endif

  <div class="mt-1">
    <!-- Existing Image Preview -->
    <div x-show="imagePreview && imagePreview.startsWith('http') && !fileName" class="mb-4">
      <div class="relative inline-block">
        <img :src="imagePreview" alt="Current Image"
             class="h-32 w-32 rounded-lg border-2 border-gray-200 object-cover">
        <button type="button" @click="imagePreview = ''; fileName = ''; $refs.fileInput.value = ''"
                class="absolute -right-2 -top-2 rounded-full bg-red-600 p-1.5 text-white hover:bg-red-700">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <div class="flex-shrink-0">
        <div class="relative h-32 w-32 overflow-hidden rounded-lg border-2 border-gray-300 bg-gray-100">
          <img x-show="imagePreview && !imagePreview.startsWith('http')" :src="imagePreview" alt="Preview"
               class="h-full w-full object-cover" x-transition>
          <div x-show="!imagePreview || (imagePreview.startsWith('http') && !fileName)"
               class="flex h-full items-center justify-center text-gray-400">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </div>

      <div class="flex-1">
        <label for="{{ $name }}" class="cursor-pointer">
          <div
               class="flex items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-3 transition-colors hover:border-primary-500 hover:bg-gray-50">
            <div class="text-center">
              <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
              <div class="mt-2 flex text-sm leading-6 text-gray-600">
                <span class="relative font-semibold text-primary-600">Upload a file</span>
                <p class="pl-1">or drag and drop</p>
              </div>
              <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to {{ $maxSize }}</p>
              <p x-show="fileName" class="mt-1 text-xs font-medium text-gray-900" x-text="fileName"></p>
            </div>
          </div>
        </label>
        <input type="file" name="{{ $name }}" id="{{ $name }}" x-ref="fileInput"
               accept="{{ $accept }}" {{ $required && !$value ? 'required' : '' }} class="sr-only"
               x-on:change="
                    const file = $event.target.files[0];
                    if (file) {
                        fileName = file.name;
                        const reader = new FileReader();
                        reader.onload = (e) => imagePreview = e.target.result;
                        reader.readAsDataURL(file);
                    }
                "
               {{ $attributes }}>
        @if ($value)
          <input type="hidden" name="{{ $name }}_existing" value="{{ $value }}">
        @endif
      </div>
    </div>

    <x-forms.error :message="$error" />
    <x-forms.help :message="$help" />
  </div>
