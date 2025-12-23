@props(['href', 'icon', 'active' => false])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 ' . ($active ? 'bg-primary-600 text-white shadow-md shadow-primary-500/20' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800')]) }}>
  @if ($active)
    <span class="absolute left-0 top-1/2 h-8 w-1 -translate-y-1/2 rounded-r-full bg-white"></span>
  @endif
  <x-icon :name="$icon"
          class="{{ $active ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }} h-5 w-5 flex-shrink-0 transition-colors" />
  <span class="flex-1">{{ $slot }}</span>
  @if ($active)
    <svg class="h-4 w-4 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
  @endif
</a>
