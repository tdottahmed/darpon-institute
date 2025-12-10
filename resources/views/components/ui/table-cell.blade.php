@props(['header' => false])

@if ($header)
  <th
      {{ $attributes->merge(['class' => 'px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-700 bg-gray-50']) }}>
    {{ $slot }}
  </th>
@else
  <td {{ $attributes->merge(['class' => 'whitespace-nowrap px-6 py-4 text-sm text-gray-900']) }}>
    {{ $slot }}
  </td>
@endif
