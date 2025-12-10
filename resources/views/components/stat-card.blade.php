@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null])

@php
  $colors = [
      'primary' => [
          'bg' => 'bg-primary-50',
          'text' => 'text-primary-600',
          'title' => 'text-primary-900',
      ],
      'secondary' => [
          'bg' => 'bg-secondary-50',
          'text' => 'text-secondary-600',
          'title' => 'text-secondary-900',
      ],
      'accent' => [
          'bg' => 'bg-accent-50',
          'text' => 'text-accent-600',
          'title' => 'text-accent-900',
      ],
      'light' => [
          'bg' => 'bg-light-50',
          'text' => 'text-light-600',
          'title' => 'text-light-900',
      ],
  ];
  $colorClasses = $colors[$color] ?? $colors['primary'];
@endphp

<div class="{{ $colorClasses['bg'] }} rounded-xl border border-gray-100 p-6 shadow-sm">
  <div class="flex items-start justify-between gap-4">
    <div class="min-w-0 flex-1">
      <p class="{{ $colorClasses['title'] }} mb-2 text-sm font-medium">{{ $title }}</p>
      <p class="{{ $colorClasses['text'] }} text-3xl font-bold leading-tight">{{ $value }}</p>
      @if ($trend)
        <p class="{{ $colorClasses['text'] }} mt-2 text-xs font-medium opacity-70">{{ $trend }}</p>
      @endif
    </div>
    @if ($icon)
      <div class="flex-shrink-0">
        <x-icon :name="$icon" class="{{ $colorClasses['text'] }} h-10 w-10 opacity-60" />
      </div>
    @endif
  </div>
</div>
