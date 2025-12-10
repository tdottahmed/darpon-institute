@props(['variant' => 'default', 'padding' => 'md'])

@php
  $variants = [
      'default' => 'bg-white shadow-sm border border-gray-200',
      'elevated' => 'bg-white shadow-md border border-gray-100',
      'outlined' => 'bg-white border-2 border-gray-200',
  ];

  $paddings = [
      'sm' => 'p-4',
      'md' => 'p-6',
      'lg' => 'p-8',
  ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl ' . $variants[$variant] . ' ' . $paddings[$padding]]) }}>
  {{ $slot }}
</div>
