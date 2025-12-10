@props(['name', 'checked' => false, 'value' => '1'])

<label class="relative inline-flex cursor-pointer items-center">
  <input type="checkbox" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}
         class="peer sr-only" {{ $attributes }}>
  <div
       class="peer h-6 w-11 rounded-full bg-gray-200 transition-colors after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all peer-checked:bg-primary-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300">
  </div>
  @if (isset($slot) && trim($slot))
    <span class="ml-3 text-sm font-medium text-gray-700">{{ $slot }}</span>
  @endif
</label>
