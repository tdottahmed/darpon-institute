@props(['message'])

@if ($message)
  <p {{ $attributes->merge(['class' => 'text-sm text-gray-500']) }}>
    {{ $message }}
  </p>
@endif
