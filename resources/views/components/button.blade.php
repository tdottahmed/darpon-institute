@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
  $variants = [
      'primary' => 'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500',
      'secondary' => 'bg-secondary-600 text-white hover:bg-secondary-700 focus:ring-secondary-500',
      'accent' => 'bg-accent-600 text-white hover:bg-accent-700 focus:ring-accent-500',
      'outline' =>
          'bg-transparent border-2 border-primary-600 text-primary-600 hover:bg-primary-50 focus:ring-primary-500',
      'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
  ];

  $sizes = [
      'sm' => 'px-3 py-1.5 text-sm',
      'md' => 'px-4 py-2 text-base',
      'lg' => 'px-6 py-3 text-lg',
  ];
@endphp

@php
  $isLink = isset($href);
@endphp

@if ($isLink)
  <a href="{{ $href }}"
     {{ $attributes->except('href')->merge(['class' => 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm hover:shadow-md ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $type }}"
          {{ $attributes->merge(['class' => 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 shadow-sm hover:shadow-md ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
  </button>
@endif
