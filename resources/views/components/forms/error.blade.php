@props(['message'])

@if ($message)
  <p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>
    {{ $message }}
  </p>
@endif
