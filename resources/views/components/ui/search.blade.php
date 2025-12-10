@props(['name' => 'search', 'placeholder' => 'Search...', 'value' => ''])

<div class="relative" x-data="{ value: '{{ $value }}' }">
  <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
  </div>
  <input type="text" name="{{ $name }}" id="{{ $name }}" x-model="value"
         value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}"
         {{ $attributes->merge(['class' => 'block w-full rounded-lg border-gray-300 pl-10 pr-10 py-2.5 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm transition-all duration-200']) }}>
  <button x-show="value" type="button" @click="value = ''; $el.closest('form').submit();"
          class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition-colors hover:text-gray-600">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>
</div>
