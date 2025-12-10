@props(['title', 'description', 'icon' => null])

<div class="flex flex-col items-center justify-center px-4 py-12">
  @if ($icon)
    <div class="mb-4">
      <x-icon :name="$icon" class="h-12 w-12 text-gray-400" />
    </div>
  @endif
  <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
  @if ($description)
    <p class="mt-2 max-w-md text-center text-sm text-gray-600">{{ $description }}</p>
  @endif
  @if (isset($slot) && trim($slot))
    <div class="mt-6">
      {{ $slot }}
    </div>
  @endif
</div>
