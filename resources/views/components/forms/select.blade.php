@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'required' => false,
    'error' => null,
    'help' => null,
    'placeholder' => 'Select an option',
])

<div class="space-y-1">
  @if ($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
      {{ $label }}
      @if ($required)
        <span class="text-red-500">*</span>
      @endif
    </label>
  @endif

  <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
          {{ $attributes->merge(['class' => 'block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm ' . ($error ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500' : '')]) }}>
    @if ($placeholder)
      <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $optionValue => $optionLabel)
      <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
        {{ $optionLabel }}
      </option>
    @endforeach
  </select>

  @if ($error)
    <p class="text-sm text-red-600">{{ $error }}</p>
  @endif

  @if ($help && !$error)
    <p class="text-sm text-gray-500">{{ $help }}</p>
  @endif
</div>
