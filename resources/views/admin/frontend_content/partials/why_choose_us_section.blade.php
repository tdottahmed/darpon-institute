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

  {{-- ────────────────────────────────────────────────────────────────────
       HOMEPAGE SECTION HEADER
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-gray-100 bg-gray-50 px-5 py-3.5">
      <span class="rounded-lg bg-blue-50 p-1.5">
        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Homepage Section Header</h3>
      <span class="ml-auto rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-600">section_badge / title / subtitle</span>
    </div>
    <div class="space-y-5 p-5">

      {{-- Badge --}}
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Badge
          <span class="ml-1 text-xs font-normal text-gray-400">small pill label above the title</span>
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
        <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
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

  {{-- ────────────────────────────────────────────────────────────────────
       FREE CLASS BUTTON & MODAL
  ──────────────────────────────────────────────────────────────────────── --}}
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

  {{-- ────────────────────────────────────────────────────────────────────
       FEATURE CARDS (Homepage + Page)
  ──────────────────────────────────────────────────────────────────────── --}}
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

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — HERO
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Hero Section</h3>
      <span class="ml-auto rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-600">/why-choose-us</span>
    </div>
    <div class="space-y-5 p-5">

      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Hero Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[page_hero_title][en]" value="{{ $getEn('page_hero_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Why Thousands Choose Darpon">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[page_hero_title][bn]" value="{{ $getBn('page_hero_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Hero Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[page_hero_subtitle][en]" rows="3"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                      placeholder="From absolute beginners to advanced professionals…">{{ $getEn('page_hero_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[page_hero_subtitle][bn]" rows="3"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('page_hero_subtitle') }}</textarea>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — STATS BAND
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Stats Band</h3>
      <span class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">4 counters</span>
    </div>
    <div class="divide-y divide-gray-100">
      @for ($n = 1; $n <= 4; $n++)
        <div class="p-5">
          <div class="mb-3 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">{{ $n }}</span>
            <p class="text-sm font-semibold text-gray-700">Stat {{ $n }}</p>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Value
                <span class="font-normal text-gray-400">(e.g. 5000+, 98%, 10K+)</span>
              </label>
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">EN</p>
                  <input type="text" name="fields[page_stat_{{ $n }}_value][en]"
                         value="{{ $getEn('page_stat_' . $n . '_value') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                         placeholder="5000+">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">BN</p>
                  <input type="text" name="fields[page_stat_{{ $n }}_value][bn]"
                         value="{{ $getBn('page_stat_' . $n . '_value') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Label</label>
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">EN</p>
                  <input type="text" name="fields[page_stat_{{ $n }}_label][en]"
                         value="{{ $getEn('page_stat_' . $n . '_label') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                         placeholder="Students Taught">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">BN</p>
                  <input type="text" name="fields[page_stat_{{ $n }}_label][bn]"
                         value="{{ $getBn('page_stat_' . $n . '_label') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </div>

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — METHODOLOGY (4 STEPS)
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Methodology</h3>
      <span class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">4 steps</span>
    </div>

    {{-- Methodology header fields --}}
    <div class="space-y-5 border-b border-gray-100 p-5">
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Badge</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[method_badge][en]" value="{{ $getEn('method_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Our Approach">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[method_badge][bn]" value="{{ $getBn('method_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[method_title][en]" value="{{ $getEn('method_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="A Proven 4-Step Learning System">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[method_title][bn]" value="{{ $getBn('method_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[method_subtitle][en]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('method_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[method_subtitle][bn]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('method_subtitle') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- Step cards --}}
    <div class="divide-y divide-gray-100">
      @for ($n = 1; $n <= 4; $n++)
        <div class="p-5">
          <div class="mb-4 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">{{ $n }}</span>
            <p class="text-sm font-semibold text-gray-700">Step {{ $n }}</p>
          </div>
          <div class="space-y-4">
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Icon
                <span class="font-normal text-gray-400">(emoji)</span>
              </label>
              <input type="text" name="fields[step_{{ $n }}_icon][en]"
                     value="{{ $getEn('step_' . $n . '_icon') }}"
                     class="block w-28 rounded-lg border-gray-300 text-center text-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
              <input type="hidden" name="fields[step_{{ $n }}_icon][bn]"
                     value="{{ $getBn('step_' . $n . '_icon') ?: $getEn('step_' . $n . '_icon') }}">
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Title</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <input type="text" name="fields[step_{{ $n }}_title][en]"
                         value="{{ $getEn('step_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <input type="text" name="fields[step_{{ $n }}_title][bn]"
                         value="{{ $getBn('step_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Description</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <textarea name="fields[step_{{ $n }}_description][en]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('step_' . $n . '_description') }}</textarea>
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <textarea name="fields[step_{{ $n }}_description][bn]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('step_' . $n . '_description') }}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endfor
    </div>
  </div>

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — OUTCOMES
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Outcomes</h3>
      <span class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">8 chips + testimonial</span>
    </div>

    {{-- Outcomes header --}}
    <div class="space-y-5 border-b border-gray-100 p-5">
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Badge</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[outcome_badge][en]" value="{{ $getEn('outcome_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Student Results">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[outcome_badge][bn]" value="{{ $getBn('outcome_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[outcome_title][en]" value="{{ $getEn('outcome_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="What Our Students Achieve">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[outcome_title][bn]" value="{{ $getBn('outcome_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[outcome_subtitle][en]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('outcome_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[outcome_subtitle][bn]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('outcome_subtitle') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- 8 outcome chips --}}
    <div class="divide-y divide-gray-100">
      @for ($n = 1; $n <= 8; $n++)
        <div class="px-5 py-3">
          <div class="flex items-start gap-3">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">{{ $n }}</span>
            <div class="flex-1">
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Outcome {{ $n }}</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <input type="text" name="fields[outcome_{{ $n }}_text][en]"
                         value="{{ $getEn('outcome_' . $n . '_text') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <input type="text" name="fields[outcome_{{ $n }}_text][bn]"
                         value="{{ $getBn('outcome_' . $n . '_text') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
          </div>
        </div>
      @endfor
    </div>

    {{-- Testimonial pull-quote --}}
    <div class="border-t border-gray-100 bg-gray-50 p-5">
      <h4 class="mb-4 flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-500">
        <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24">
          <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
        </svg>
        Testimonial Pull-Quote
      </h4>
      <div class="space-y-4">
        <div>
          <label class="mb-1.5 block text-xs font-medium text-gray-600">Quote</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <textarea name="fields[testimonial_quote][en]" rows="3"
                        class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('testimonial_quote') }}</textarea>
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <textarea name="fields[testimonial_quote][bn]" rows="3"
                        class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('testimonial_quote') }}</textarea>
            </div>
          </div>
        </div>
        <div>
          <label class="mb-1.5 block text-xs font-medium text-gray-600">Author</label>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
              <input type="text" name="fields[testimonial_author][en]" value="{{ $getEn('testimonial_author') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                     placeholder="Farhan A., Software Engineer">
            </div>
            <div>
              <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
              <input type="text" name="fields[testimonial_author][bn]" value="{{ $getBn('testimonial_author') }}"
                     class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — DIFFERENTIATORS (3 CARDS)
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Differentiators</h3>
      <span class="ml-auto rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-500">3 cards × 3 bullet points</span>
    </div>

    {{-- Diff section header --}}
    <div class="space-y-5 border-b border-gray-100 p-5">
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Badge</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[diff_badge][en]" value="{{ $getEn('diff_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="What Sets Us Apart">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[diff_badge][bn]" value="{{ $getBn('diff_badge') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[diff_title][en]" value="{{ $getEn('diff_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="We Do Things Differently">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[diff_title][bn]" value="{{ $getBn('diff_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>
      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[diff_subtitle][en]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('diff_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[diff_subtitle][bn]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('diff_subtitle') }}</textarea>
          </div>
        </div>
      </div>
    </div>

    {{-- 3 differentiator cards --}}
    <div class="divide-y divide-gray-100">
      @for ($n = 1; $n <= 3; $n++)
        <div class="p-5">
          <div class="mb-4 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700">{{ $n }}</span>
            <p class="text-sm font-semibold text-gray-700">Differentiator {{ $n }}</p>
          </div>
          <div class="space-y-4">
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Icon
                <span class="font-normal text-gray-400">(emoji)</span>
              </label>
              <input type="text" name="fields[diff_{{ $n }}_icon][en]"
                     value="{{ $getEn('diff_' . $n . '_icon') }}"
                     class="block w-28 rounded-lg border-gray-300 text-center text-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
              <input type="hidden" name="fields[diff_{{ $n }}_icon][bn]"
                     value="{{ $getBn('diff_' . $n . '_icon') ?: $getEn('diff_' . $n . '_icon') }}">
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Title</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <input type="text" name="fields[diff_{{ $n }}_title][en]"
                         value="{{ $getEn('diff_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <input type="text" name="fields[diff_{{ $n }}_title][bn]"
                         value="{{ $getBn('diff_' . $n . '_title') }}"
                         class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                </div>
              </div>
            </div>
            <div>
              <label class="mb-1.5 block text-xs font-medium text-gray-600">Description</label>
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                  <textarea name="fields[diff_{{ $n }}_description][en]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getEn('diff_' . $n . '_description') }}</textarea>
                </div>
                <div>
                  <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                  <textarea name="fields[diff_{{ $n }}_description][bn]" rows="2"
                            class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('diff_' . $n . '_description') }}</textarea>
                </div>
              </div>
            </div>
            {{-- 3 bullet points --}}
            @for ($p = 1; $p <= 3; $p++)
              <div>
                <label class="mb-1.5 block text-xs font-medium text-gray-600">Bullet Point {{ $p }}</label>
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
                    <input type="text" name="fields[diff_{{ $n }}_point_{{ $p }}][en]"
                           value="{{ $getEn('diff_' . $n . '_point_' . $p) }}"
                           class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                  </div>
                  <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
                    <input type="text" name="fields[diff_{{ $n }}_point_{{ $p }}][bn]"
                           value="{{ $getBn('diff_' . $n . '_point_' . $p) }}"
                           class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
                  </div>
                </div>
              </div>
            @endfor
          </div>
        </div>
      @endfor
    </div>
  </div>

  {{-- ────────────────────────────────────────────────────────────────────
       DEDICATED PAGE — BOTTOM CTA
  ──────────────────────────────────────────────────────────────────────── --}}
  <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm">
    <div class="flex items-center gap-2.5 border-b border-indigo-100 bg-indigo-50 px-5 py-3.5">
      <span class="rounded-lg bg-indigo-100 p-1.5">
        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
        </svg>
      </span>
      <h3 class="text-sm font-semibold text-gray-700">Dedicated Page — Bottom CTA</h3>
    </div>
    <div class="space-y-5 p-5">

      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">CTA Title</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <input type="text" name="fields[page_cta_title][en]" value="{{ $getEn('page_cta_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   placeholder="Ready to Speak English with Confidence?">
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <input type="text" name="fields[page_cta_title][bn]" value="{{ $getBn('page_cta_title') }}"
                   class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">
          </div>
        </div>
      </div>

      <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">CTA Subtitle</label>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">English</p>
            <textarea name="fields[page_cta_subtitle][en]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                      placeholder="Join thousands of students who transformed…">{{ $getEn('page_cta_subtitle') }}</textarea>
          </div>
          <div>
            <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">Bengali</p>
            <textarea name="fields[page_cta_subtitle][bn]" rows="2"
                      class="block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $getBn('page_cta_subtitle') }}</textarea>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- ── SAVE ──────────────────────────────────────────────────────────── --}}
  <div class="-mx-6 -mb-6 border-t border-gray-200 bg-white px-6 py-4 shadow-lg">
    <div class="flex items-center justify-between">
      <p class="text-sm text-gray-500">Changes apply to both the homepage section and the <strong>/why-choose-us</strong> page immediately after saving.</p>
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
