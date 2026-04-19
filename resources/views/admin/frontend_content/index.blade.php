@extends('layouts.admin')

@section('content')
  <div class="rounded-lg bg-white p-6 shadow">
    <div x-data="{
        activeSection: '{{ $activeSection }}',
        init() {
            // Update active section from URL on mount
            const urlParams = new URLSearchParams(window.location.search);
            const sectionParam = urlParams.get('section');
            if (sectionParam) {
                this.activeSection = sectionParam;
            }
        }
    }">
      <!-- Header -->
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Frontend Content Management</h1>
        <p class="mt-1 text-sm text-gray-600">Manage content for different sections of your website</p>
      </div>

      <!-- Tabs Navigation -->
      <div class="mb-6 border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
          @foreach ($contents as $section => $items)
            <button @click="activeSection = '{{ $section }}'; window.history.replaceState({}, '', '?section={{ $section }}');"
                    :class="{ 'border-primary-500 text-primary-600': activeSection === '{{ $section }}', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeSection !== '{{ $section }}' }"
                    class="whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition-colors duration-200">
              {{ ucfirst($section) }}
            </button>
          @endforeach
        </nav>
      </div>

      <!-- Flash Messages -->
      @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
          {{ session('success') }}
        </div>
      @endif

      <!-- Content Area with Fixed Height and Scroll -->
      <div class="relative" style="height: calc(100vh - 300px); min-height: 600px;">
        @foreach ($contents as $section => $items)
          <div x-show="activeSection === '{{ $section }}'" class="absolute inset-0 overflow-y-auto"
               style="display: {{ $section === $activeSection ? 'block' : 'none' }};">

            @if ($section === 'hero')
              @include('admin.frontend_content.partials.hero_section', [
                  'items' => $items,
                  'section' => $section,
              ])
            @else
              <!-- Single Form for All Fields in Section -->
              <form action="{{ route('admin.frontend-content.update') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6 pb-6">
                @csrf
                <input type="hidden" name="section" value="{{ $section }}">

                @foreach ($items as $item)
                  <div class="rounded-lg border border-gray-200 bg-gray-50 p-6">
                    <div class="mb-4 flex items-center justify-between">
                      <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                          {{ ucwords(str_replace('_', ' ', $item->key)) }}
                        </label>
                        <p class="text-xs text-gray-500">{{ $item->key }}</p>
                      </div>

                      @if ($section !== 'hero')
                        <button type="button" onclick="deleteContent({{ $item->id }}, '{{ $section }}')"
                                class="text-gray-400 transition-colors hover:text-red-600" title="Remove Content">
                          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                          </svg>
                        </button>
                      @endif

                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                      <!-- English -->
                      <div class="space-y-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">English</label>
                        @php $valEn = is_array($item->value) ? ($item->value['en'] ?? '') : $item->value; @endphp

                        @if ($item->type === 'image')
                          @if ($valEn)
                            <div class="mb-2">
                              <img src="{{ $valEn }}" alt="English"
                                   class="h-32 w-full rounded-lg border object-cover">
                              <input type="hidden" name="fields[{{ $item->key }}][en_existing]"
                                     value="{{ $valEn }}">
                            </div>
                          @endif
                          <input type="file" name="fields[{{ $item->key }}][en]"
                                 class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100"
                                 accept="image/*">
                          <p class="mt-1 text-xs text-gray-400">Leave empty to keep current image</p>
                        @elseif($item->key === 'hero_mode')
                          <select name="fields[{{ $item->key }}][en]"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="image" {{ $valEn === 'image' ? 'selected' : '' }}>Background Image</option>
                            <option value="slider" {{ $valEn === 'slider' ? 'selected' : '' }}>Image Slider</option>
                          </select>
                          <p class="mt-1 text-xs text-gray-400">Choose "Image Slider" to rotate through slider images</p>
                        @elseif($item->type === 'textarea')
                          @if (str_contains(strtolower($item->key), 'description') ||
                                  str_contains(strtolower($item->key), 'content') ||
                                  str_contains(strtolower($item->key), 'answer'))
                            <div class="mb-12">
                              <x-forms.rich-text name="fields[{{ $item->key }}][en]" :value="$valEn"
                                                 height="200px" />
                            </div>
                          @else
                            <textarea name="fields[{{ $item->key }}][en]" rows="6"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $valEn }}</textarea>
                          @endif
                        @else
                          <input type="text" name="fields[{{ $item->key }}][en]" value="{{ $valEn }}"
                                 class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @endif
                      </div>

                      <!-- Bengali -->
                      <div class="space-y-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500">Bengali</label>
                        @php $valBn = is_array($item->value) ? ($item->value['bn'] ?? '') : ''; @endphp

                        @if ($item->type === 'image')
                          @if ($valBn)
                            <div class="mb-2">
                              <img src="{{ $valBn }}" alt="Bengali"
                                   class="h-32 w-full rounded-lg border object-cover">
                              <input type="hidden" name="fields[{{ $item->key }}][bn_existing]"
                                     value="{{ $valBn }}">
                            </div>
                          @endif
                          <input type="file" name="fields[{{ $item->key }}][bn]"
                                 class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100"
                                 accept="image/*">
                          <p class="mt-1 text-xs text-gray-400">Leave empty to keep current image</p>
                        @elseif($item->key === 'hero_mode')
                          <select name="fields[{{ $item->key }}][bn]"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="image" {{ $valBn === 'image' ? 'selected' : '' }}>Background Image</option>
                            <option value="slider" {{ $valBn === 'slider' ? 'selected' : '' }}>Image Slider</option>
                          </select>
                          <p class="mt-1 text-xs text-gray-400">Choose "Image Slider" to rotate through slider images</p>
                        @elseif($item->type === 'textarea')
                          @if (str_contains(strtolower($item->key), 'description') ||
                                  str_contains(strtolower($item->key), 'content') ||
                                  str_contains(strtolower($item->key), 'answer'))
                            <div class="mb-12">
                              <x-forms.rich-text name="fields[{{ $item->key }}][bn]" :value="$valBn"
                                                 height="200px" />
                            </div>
                          @else
                            <textarea name="fields[{{ $item->key }}][bn]" rows="6"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $valBn }}</textarea>
                          @endif
                        @else
                          <input type="text" name="fields[{{ $item->key }}][bn]" value="{{ $valBn }}"
                                 class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach

                <!-- Submit Button -->
                <div class="-mx-6 -mb-6 mt-8 rounded-b-lg border-t border-gray-200 bg-white p-4 shadow-lg">
                  <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                      All changes will be saved when you click "Save Section"
                    </p>
                    <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-primary-600 px-6 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                      <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                      </svg>
                      Save Section
                    </button>
                  </div>
                </div>
              </form>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Hidden form for delete operations -->
  <form id="deleteForm" method="POST" style="display: none;">
    @csrf
  </form>

  <script>
    function deleteContent(id, section) {
      if (!confirm('Are you sure you want to remove this content? This action cannot be undone.')) {
        return;
      }

      const form = document.getElementById('deleteForm');
      const baseUrl = '{{ url('/admin/frontend-content') }}';
      form.action = baseUrl + '/' + id;
      form.submit();
    }
  </script>
@endsection
