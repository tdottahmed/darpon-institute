@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'error' => null,
    'help' => null,
    'accept' => 'video/*',
    'maxSize' => '50MB',
])

<div class="space-y-1" x-data="{
    videoPreview: null,
    fileName: '',
    existingVideo: '{{ $value }}',
    isUploading: false,
    uploadProgress: 0
}">
  @if ($label)
    <x-forms.label :for="$name" :required="$required">{{ $label }}</x-forms.label>
  @endif

  <div class="mt-1">
    <!-- Existing Video Preview -->
    <div x-show="existingVideo && !videoPreview && !fileName" class="mb-4">
      <div class="relative rounded-lg border-2 border-gray-200 bg-gray-50 p-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary-100">
              <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-900">Current Video</p>
              <p class="text-xs text-gray-500">Video file is already uploaded</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <a :href="existingVideo.startsWith('http') ? existingVideo : '/storage/' + existingVideo" target="_blank"
               class="inline-flex items-center rounded-md bg-primary-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-primary-700">
              View Video
            </a>
            <button type="button"
                    @click="existingVideo = ''; fileName = ''; videoPreview = null; $refs.fileInput.value = ''"
                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
              Remove
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- New Video Preview -->
    <div x-show="videoPreview" class="mb-4">
      <div class="relative rounded-lg border-2 border-primary-200 bg-primary-50 p-4">
        <video :src="videoPreview" controls class="w-full rounded-lg" style="max-height: 300px;"></video>
        <button type="button" @click="videoPreview = null; fileName = ''; $refs.fileInput.value = ''"
                class="absolute right-2 top-2 rounded-full bg-red-600 p-1.5 text-white hover:bg-red-700">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Upload Area -->
    <label for="{{ $name }}" class="cursor-pointer">
      <div
           class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-6 py-8 transition-all hover:border-primary-500 hover:bg-gray-50">
        <div class="text-center">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
          <div class="mt-4 flex text-sm leading-6 text-gray-600">
            <span class="relative font-semibold text-primary-600">Upload a video</span>
            <p class="pl-1">or drag and drop</p>
          </div>
          <p class="text-xs leading-5 text-gray-600">MP4, MOV up to {{ $maxSize }}</p>
          <p x-show="fileName" class="mt-2 text-sm font-medium text-gray-900" x-text="fileName"></p>
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
                    reader.onload = (e) => videoPreview = e.target.result;
                    reader.readAsDataURL(file);
                }
            "
           {{ $attributes }}>

    @if ($value)
      <input type="hidden" name="{{ $name }}_existing" value="{{ $value }}">
    @endif
  </div>

  <x-forms.error :message="$error" />
  <x-forms.help :message="$help" />
</div>
