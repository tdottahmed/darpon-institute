@props(['striped' => false])

<tbody
       {{ $attributes->merge(['class' => 'divide-y divide-gray-200 bg-white' . ($striped ? ' divide-y divide-gray-200' : '')]) }}>
  {{ $slot }}
</tbody>
