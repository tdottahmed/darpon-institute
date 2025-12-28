@props([
    'name',
    'label',
    'id' => null,
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

  <div class="relative">
    <select name="{{ $name }}" id="{{ $id ?? $name }}" {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block w-full appearance-none rounded-lg border-gray-300 bg-white py-2.5 pl-3 pr-10 text-sm text-gray-900 shadow-sm transition-colors focus:border-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 ' . ($error ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500' : '')]) }}>
      @if ($placeholder)
        <option value="" disabled selected class="cursor-not-allowed text-gray-400 opacity-100">{{ $placeholder }}
        </option>
      @endif

      @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
          {{ $optionLabel }}
        </option>
      @endforeach
    </select>
  </div>

  @if ($error)
    <p class="text-sm text-red-600">{{ $error }}</p>
  @endif

  @if ($help && !$error)
    <p class="text-sm text-gray-500">{{ $help }}</p>
  @endif
</div>
