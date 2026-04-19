@php
  $byKey = $items->keyBy('key');
  $getEn = fn($key) => is_array($byKey->get($key)?->value)
      ? $byKey->get($key)?->value['en'] ?? ''
      : $byKey->get($key)?->value ?? '';
  $getBn = fn($key) => is_array($byKey->get($key)?->value) ? $byKey->get($key)?->value['bn'] ?? '' : '';
  $heroMode = $getEn('hero_mode') ?: 'image';
@endphp

<div x-data="{ mode: '{{ $heroMode }}' }">
  <form action="{{ route('admin.frontend-content.update') }}" method="POST" enctype="multipart/form-data"
        class="space-y-5 pb-6">
    @csrf
    <input type="hidden" name="section" value="hero">

    {{-- ── TEXT CONTENT ─────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
        <span class="rounded-lg bg-blue-50 p-1.5">
          <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
          </svg>
        </span>
        <h3 class="text-sm font-semibold text-gray-700">Text Content</h3>
      </div>
      <div class="space-y-5 p-5">

        {{-- Badge --}}
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-700">Badge</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <input type="text" name="fields[badge][en]" value="{{ $getEn('badge') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                     placeholder="e.g. Trusted Learning Platform">
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <input type="text" name="fields[badge][bn]" value="{{ $getBn('badge') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
          </div>
        </div>

        {{-- Title Line 1 --}}
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-700">Title — Line 1
            <span class="ml-1 text-xs font-normal text-gray-400">(main headline)</span>
          </label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <input type="text" name="fields[title_line_1][en]" value="{{ $getEn('title_line_1') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <input type="text" name="fields[title_line_1][bn]" value="{{ $getBn('title_line_1') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
          </div>
        </div>

        {{-- Title Line 2 --}}
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-700">Title — Line 2
            <span class="ml-1 text-xs font-normal text-gray-400">(sub-headline, smaller)</span>
          </label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <input type="text" name="fields[title_line_2][en]" value="{{ $getEn('title_line_2') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <input type="text" name="fields[title_line_2][bn]" value="{{ $getBn('title_line_2') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
          </div>
        </div>

        {{-- Description --}}
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <div class="mb-12">
                <x-forms.rich-text name="fields[description][en]" :value="$getEn('description')" height="130px" />
              </div>
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <div class="mb-12">
                <x-forms.rich-text name="fields[description][bn]" :value="$getBn('description')" height="130px" />
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- ── BUTTONS ──────────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
        <span class="rounded-lg bg-green-50 p-1.5">
          <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3-3 3m-5-3h8" />
          </svg>
        </span>
        <h3 class="text-sm font-semibold text-gray-700">CTA Buttons</h3>
      </div>
      <div class="grid grid-cols-2 gap-4 p-5">

        {{-- Button 1 --}}
        <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50 p-4">
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Primary Button</p>
          <div>
            <p class="mb-1 text-xs text-gray-400">Text (English)</p>
            <input type="text" name="fields[button_1_text][en]" value="{{ $getEn('button_1_text') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Find Courses">
          </div>
          <div>
            <p class="mb-1 text-xs text-gray-400">Text (Bengali)</p>
            <input type="text" name="fields[button_1_text][bn]" value="{{ $getBn('button_1_text') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
          <div>
            <p class="mb-1 text-xs text-gray-400">Link URL</p>
            <input type="text" name="fields[button_1_link][en]" value="{{ $getEn('button_1_link') }}"
                   class="block w-full rounded-lg border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="/courses">
            <input type="hidden" name="fields[button_1_link][bn]"
                   value="{{ $getBn('button_1_link') ?: $getEn('button_1_link') }}">
          </div>
        </div>

        {{-- Button 2 --}}
        <div class="space-y-3 rounded-lg border border-gray-200 bg-gray-50 p-4">
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Secondary Button</p>
          <div>
            <p class="mb-1 text-xs text-gray-400">Text (English)</p>
            <input type="text" name="fields[button_2_text][en]" value="{{ $getEn('button_2_text') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Find Books">
          </div>
          <div>
            <p class="mb-1 text-xs text-gray-400">Text (Bengali)</p>
            <input type="text" name="fields[button_2_text][bn]" value="{{ $getBn('button_2_text') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
          <div>
            <p class="mb-1 text-xs text-gray-400">Link URL</p>
            <input type="text" name="fields[button_2_link][en]" value="{{ $getEn('button_2_link') }}"
                   class="block w-full rounded-lg border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="/books">
            <input type="hidden" name="fields[button_2_link][bn]"
                   value="{{ $getBn('button_2_link') ?: $getEn('button_2_link') }}">
          </div>
        </div>

      </div>
    </div>

    {{-- ── BACKGROUND ───────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
        <span class="rounded-lg bg-purple-50 p-1.5">
          <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </span>
        <h3 class="text-sm font-semibold text-gray-700">Background</h3>
      </div>
      <div class="p-5">

        {{-- Mode toggle --}}
        <div class="mb-5">
          <p class="mb-3 text-sm font-medium text-gray-700">Display Mode</p>
          <div class="flex gap-3">

            <label :class="mode === 'image'
                ?
                'ring-2 ring-primary-500 border-primary-300 bg-primary-50' :
                'border-gray-200 bg-white hover:bg-gray-50'"
                   class="flex cursor-pointer select-none items-center gap-3 rounded-xl border px-4 py-3 transition-all">
              <input type="radio" name="fields[hero_mode][en]" value="image" x-model="mode" class="sr-only">
              <div :class="mode === 'image' ? 'bg-primary-500' : 'bg-gray-300'"
                   class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full transition-colors">
                <div x-show="mode === 'image'" class="h-2 w-2 rounded-full bg-white"></div>
              </div>
              <div>
                <p :class="mode === 'image' ? 'text-primary-700' : 'text-gray-700'"
                   class="text-sm font-semibold leading-none">Static Image</p>
                <p class="mt-0.5 text-xs text-gray-400">Single background photo</p>
              </div>
            </label>

            <label :class="mode === 'slider'
                ?
                'ring-2 ring-primary-500 border-primary-300 bg-primary-50' :
                'border-gray-200 bg-white hover:bg-gray-50'"
                   class="flex cursor-pointer select-none items-center gap-3 rounded-xl border px-4 py-3 transition-all">
              <input type="radio" name="fields[hero_mode][en]" value="slider" x-model="mode" class="sr-only">
              <div :class="mode === 'slider' ? 'bg-primary-500' : 'bg-gray-300'"
                   class="flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full transition-colors">
                <div x-show="mode === 'slider'" class="h-2 w-2 rounded-full bg-white"></div>
              </div>
              <div>
                <p :class="mode === 'slider' ? 'text-primary-700' : 'text-gray-700'"
                   class="text-sm font-semibold leading-none">Image Slider</p>
                <p class="mt-0.5 text-xs text-gray-400">Auto-rotates every 5s</p>
              </div>
            </label>

          </div>
          <input type="hidden" name="fields[hero_mode][bn]" x-bind:value="mode">
        </div>

        {{-- Static image upload --}}
        <div x-show="mode === 'image'" x-transition>
          <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Background Image</p>
          <div class="grid grid-cols-2 gap-4">
            @foreach (['en' => 'English', 'bn' => 'Bengali'] as $lang => $langLabel)
              @php $imgVal = $lang === 'en' ? $getEn('hero_image') : $getBn('hero_image'); @endphp
              <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-400">{{ $langLabel }}</p>
                @if ($imgVal)
                  <div class="group relative mb-2 overflow-hidden rounded-xl border border-gray-200">
                    <img src="{{ $imgVal }}" class="h-36 w-full object-cover">
                    <input type="hidden" name="fields[hero_image][{{ $lang }}_existing]"
                           value="{{ $imgVal }}">
                    <div
                         class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                      <span class="rounded bg-black/50 px-2 py-1 text-xs font-medium text-white">Replace below</span>
                    </div>
                  </div>
                @else
                  <div
                       class="mb-2 flex h-36 flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 bg-gray-100">
                    <svg class="mb-1 h-8 w-8 text-gray-300" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs text-gray-400">No image yet</p>
                  </div>
                @endif
                <input type="file" name="fields[hero_image][{{ $lang }}]" accept="image/*"
                       class="block w-full cursor-pointer text-sm text-slate-500 file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-3 file:py-1.5 file:text-sm file:font-medium file:text-primary-700 hover:file:bg-primary-100">
              </div>
            @endforeach
          </div>
        </div>

        {{-- Slider images --}}
        <div x-show="mode === 'slider'" x-transition>
          <div class="mb-3 flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Slider Images</p>
            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-400">Min 2 · Max 5</span>
          </div>
          <div class="grid grid-cols-2 gap-3 lg:grid-cols-3 xl:grid-cols-5">
            @for ($n = 1; $n <= 5; $n++)
              @php
                $sk = "slider_image_{$n}";
                $sv = $getEn($sk);
              @endphp
              <div
                   class="{{ $sv ? 'border-primary-200 bg-primary-50/30' : 'border-dashed border-gray-200 bg-gray-50' }} rounded-xl border-2 p-2.5 transition-colors hover:border-primary-300">
                <div class="mb-2 flex items-center justify-between">
                  <span class="{{ $sv ? 'text-primary-600' : 'text-gray-400' }} text-xs font-semibold">Slide
                    {{ $n }}</span>
                  @if ($sv)
                    <span class="h-2 w-2 rounded-full bg-green-400"></span>
                  @endif
                </div>
                @if ($sv)
                  <div class="mb-2 overflow-hidden rounded-lg">
                    <img src="{{ $sv }}" class="h-20 w-full object-cover">
                  </div>
                  <input type="hidden" name="fields[{{ $sk }}][en_existing]"
                         value="{{ $sv }}">
                  <input type="hidden" name="fields[{{ $sk }}][bn_existing]"
                         value="{{ $sv }}">
                @else
                  <div class="mb-2 flex h-20 items-center justify-center rounded-lg border border-gray-200 bg-white">
                    <svg class="h-6 w-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                    </svg>
                  </div>
                @endif
                <input type="file" name="fields[{{ $sk }}][en]" accept="image/*"
                       class="block w-full cursor-pointer text-xs text-slate-500 file:mr-1 file:rounded-md file:border-0 file:bg-primary-50 file:px-2 file:py-1 file:text-xs file:font-medium file:text-primary-700 hover:file:bg-primary-100">
              </div>
            @endfor
          </div>
          <p class="mt-2 text-xs text-gray-400">Uploaded slides auto-rotate on the homepage. Empty slots are skipped.
          </p>
        </div>

      </div>
    </div>

    {{-- ── STATISTICS ───────────────────────────────────────── --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
        <span class="rounded-lg bg-orange-50 p-1.5">
          <svg class="h-4 w-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </span>
        <h3 class="text-sm font-semibold text-gray-700">Statistics Bar</h3>
        <span class="text-xs text-gray-400">Leave all empty to hide</span>
      </div>
      <div class="p-5">
        <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
          @for ($n = 1; $n <= 4; $n++)
            <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50 p-4">
              <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Stat {{ $n }}</p>
              <div class="space-y-2">
                <div>
                  <p class="mb-1 text-xs text-gray-400">Value (EN) <span class="text-gray-300">e.g. 5000+</span></p>
                  <input type="text" name="fields[stat_{{ $n }}_value][en]"
                         value="{{ $getEn('stat_' . $n . '_value') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs text-gray-400">Value (BN)</p>
                  <input type="text" name="fields[stat_{{ $n }}_value][bn]"
                         value="{{ $getBn('stat_' . $n . '_value') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs text-gray-400">Label (EN) <span class="text-gray-300">e.g. Students</span>
                  </p>
                  <input type="text" name="fields[stat_{{ $n }}_label][en]"
                         value="{{ $getEn('stat_' . $n . '_label') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs text-gray-400">Label (BN)</p>
                  <input type="text" name="fields[stat_{{ $n }}_label][bn]"
                         value="{{ $getBn('stat_' . $n . '_label') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
          @endfor
        </div>
      </div>
    </div>

    {{-- ── SAVE ─────────────────────────────────────────────── --}}
    <div class="-mx-6 -mb-6 border-t border-gray-200 bg-white px-6 py-4 shadow-lg">
      <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">Changes are applied to the homepage hero section immediately after saving.</p>
        <button type="submit"
                class="inline-flex items-center gap-2 rounded-lg border border-transparent bg-primary-600 px-6 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Save Hero Section
        </button>
      </div>
    </div>

  </form>
</div>
