@props(['variant' => 'primary', 'size' => 'md'])

@php
  $variants = [
      'primary' => 'bg-primary-100 text-primary-800 border-primary-200',
      'secondary' => 'bg-secondary-100 text-secondary-800 border-secondary-200',
      'accent' => 'bg-accent-100 text-accent-800 border-accent-200',
      'light' => 'bg-light-100 text-light-800 border-light-200',
      'success' => 'bg-green-100 text-green-800 border-green-200',
      'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
      'danger' => 'bg-red-100 text-red-800 border-red-200',
      'info' => 'bg-blue-100 text-blue-800 border-blue-200',
      'gray' => 'bg-gray-100 text-gray-800 border-gray-200',
  ];

  $sizes = [
      'sm' => 'px-2 py-0.5 text-xs',
      'md' => 'px-2.5 py-1 text-sm',
      'lg' => 'px-3 py-1.5 text-base',
  ];
@endphp

<span
      {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full border font-medium ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
  {{ $slot }}
</span>
