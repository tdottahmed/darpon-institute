@props(['href', 'icon', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 ' . ($active ? 'bg-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-gray-400 hover:bg-gray-800 hover:text-white')]) }}>
  <x-icon :name="$icon"
          class="{{ $active ? 'text-white' : 'text-gray-500 group-hover:text-white' }} h-5 w-5 flex-shrink-0" />
  <span>{{ $slot }}</span>
</a>
