@php
  $byKey = $items->keyBy('key');
  $getEn = fn($key) => is_array($byKey->get($key)?->value)
      ? $byKey->get($key)?->value['en'] ?? ''
      : $byKey->get($key)?->value ?? '';
  $getBn = fn($key) => is_array($byKey->get($key)?->value) ? $byKey->get($key)?->value['bn'] ?? '' : '';
@endphp

<form action="{{ route('admin.frontend-content.update') }}" method="POST" enctype="multipart/form-data"
      class="space-y-5 pb-6">
  @csrf
  <input type="hidden" name="section" value="why_choose_us">

  {{-- ── SECTION HEADER ──────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
      <span class="rounded-lg bg-blue-50 p-1.5">
        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Section Header</h3>
    </div>
    <div class="space-y-5 p-5">

      {{-- Badge --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Badge
          <span class="ml-1 text-xs font-normal text-gray-400">small label above the title</span>
        </label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[section_badge][en]" value="{{ $getEn('section_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Why Choose Us">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[section_badge][bn]" value="{{ $getBn('section_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      {{-- Title --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[section_title][en]" value="{{ $getEn('section_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="The Best Place to Learn English">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[section_title][bn]" value="{{ $getBn('section_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      {{-- Subtitle --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle
          <span class="ml-1 text-xs font-normal text-gray-400">short description below the title</span>
        </label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[section_subtitle][en]" rows="3"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                      placeholder="We combine expert teaching, modern methods…">{{ $getEn('section_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[section_subtitle][bn]" rows="3"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('section_subtitle') }}</textarea>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── FREE CLASS CTA ──────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
      <span class="rounded-lg bg-primary-50 p-1.5">
        <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Free Class Button & Modal</h3>
    </div>
    <div class="space-y-5 p-5">

      {{-- Button label --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Button Label</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[btn_free_class_label][en]" value="{{ $getEn('btn_free_class_label') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Join Our Free Class">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[btn_free_class_label][bn]" value="{{ $getBn('btn_free_class_label') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      {{-- Modal title --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Modal Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[modal_title][en]" value="{{ $getEn('modal_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Register for a Free Class">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[modal_title][bn]" value="{{ $getBn('modal_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      {{-- Modal subtitle --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Modal Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[modal_subtitle][en]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                      placeholder="Fill in your details and we'll reach out…">{{ $getEn('modal_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[modal_subtitle][bn]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('modal_subtitle') }}</textarea>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── FEATURE CARDS ────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
      <span class="rounded-lg bg-green-50 p-1.5">
        <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Feature Cards</h3>
      <span class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">6 cards</span>
    </div>
    <div class="divide-y divide-gray-100">
      @for ($n = 1; $n <= 6; $n++)
        <div class="p-5">
          <div class="mb-4 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">{{ $n }}</span>
            <p class="text-sm font-semibold text-gray-700">Feature {{ $n }}</p>
          </div>

          <div class="space-y-4">
            {{-- Icon --}}
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Icon
                <span class="font-normal text-gray-400">(emoji, e.g. 🎯 📚 🏆)</span>
              </label>
              <input type="text" name="fields[feature_{{ $n }}_icon][en]"
                     value="{{ $getEn('feature_' . $n . '_icon') }}"
                     class="block w-28 rounded-lg border-gray-300 text-center text-lg shadow-sm focus:border-primary-500 focus:ring-primary-500"
                     placeholder="🎯">
              <input type="hidden" name="fields[feature_{{ $n }}_icon][bn]"
                     value="{{ $getBn('feature_' . $n . '_icon') ?: $getEn('feature_' . $n . '_icon') }}">
            </div>

            {{-- Title --}}
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Title</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <input type="text" name="fields[feature_{{ $n }}_title][en]"
                         value="{{ $getEn('feature_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <input type="text" name="fields[feature_{{ $n }}_title][bn]"
                         value="{{ $getBn('feature_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>

            {{-- Description --}}
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Description</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <textarea name="fields[feature_{{ $n }}_description][en]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('feature_' . $n . '_description') }}</textarea>
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <textarea name="fields[feature_{{ $n }}_description][bn]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('feature_' . $n . '_description') }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </div>

  {{-- ── SAVE ─────────────────────────────────────────────── --}}
  <div class="-mx-6 -mb-6 border-t border-gray-200 bg-white px-6 py-4 shadow-lg">
    <div class="flex items-center justify-between">
      <p class="text-sm text-gray-500">Changes are applied to the homepage immediately after saving.</p>
      <button type="submit"
              class="inline-flex items-center gap-2 rounded-lg border border-transparent bg-primary-600 px-6 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Save Why Choose Us
      </button>
    </div>
  </div>

</form>
