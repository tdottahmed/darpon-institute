@props(['href', 'variant' => 'default', 'size' => 'md'])

@php
  $variants = [
      'default' => 'text-gray-700 hover:text-primary-600 border-gray-300 hover:border-primary-500',
      'primary' => 'bg-primary-600 text-white hover:bg-primary-700 border-primary-600 shadow-sm hover:shadow-md',
      'secondary' =>
          'bg-secondary-600 text-white hover:bg-secondary-700 border-secondary-600 shadow-sm hover:shadow-md',
      'accent' => 'bg-accent-600 text-white hover:bg-accent-700 border-accent-600 shadow-sm hover:shadow-md',
      'outline' => 'bg-transparent border-2 border-primary-600 text-primary-600 hover:bg-primary-50',
      'danger' => 'bg-red-600 text-white hover:bg-red-700 border-red-600 shadow-sm hover:shadow-md',
      'ghost' => 'text-gray-700 hover:bg-gray-100 border-transparent',
  ];

  $sizes = [
      'sm' => 'px-3 py-1.5 text-sm',
      'md' => 'px-4 py-2 text-base',
      'lg' => 'px-6 py-3 text-lg',
  ];

  $isButtonStyle = in_array($variant, ['primary', 'secondary', 'accent', 'outline', 'danger']);
@endphp

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'inline-flex items-center justify-center font-semibold rounded-xl border transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 ' . ($isButtonStyle ? 'transform hover:scale-105 active:scale-95' : '') . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
  {{ $slot }}
</a>
