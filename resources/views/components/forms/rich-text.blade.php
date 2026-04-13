@props(['name', 'label' => null, 'value' => '', 'required' => false, 'error' => null, 'help' => null, 'height' => '300px'])

@php
  $safeId = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name) . '_' . Str::random(4);
@endphp

@push('styles')
  <link href="{{ asset('css/quill/quill.snow.css') }}" rel="stylesheet">
@endpush

@push('scripts')
  <script src="{{ asset('js/quill/quill.js') }}"></script>
@endpush

<div class="space-y-1">
  @if ($label)
    <label for="{{ $safeId }}" class="block text-sm font-medium text-gray-700">
      {{ $label }}
      @if ($required)
        <span class="text-red-500">*</span>
      @endif
    </label>
  @endif

  <div id="editor-{{ $safeId }}" style="height: {{ $height }};"></div>
  <input type="hidden" name="{{ $name }}" id="input-{{ $safeId }}" value="{{ old($name, $value) }}">

  @if ($error)
    <p class="text-sm text-red-600">{{ $error }}</p>
  @endif

  @if ($help && !$error)
    <p class="text-sm text-gray-500">{{ $help }}</p>
  @endif
</div>

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var quill = new Quill('#editor-{{ $safeId }}', {
        theme: 'snow',
        modules: {
          toolbar: [
            [{
              'header': [1, 2, 3, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            [{
              'list': 'ordered'
            }, {
              'list': 'bullet'
            }],
            [{
              'color': []
            }, {
              'background': []
            }],
            ['link', 'image'],
            ['clean']
          ]
        }
      });

      @if ($value)
        quill.root.innerHTML = {!! json_encode($value) !!};
      @endif

      quill.on('text-change', function() {
        document.getElementById('input-{{ $safeId }}').value = quill.root.innerHTML;
      });
    });
  </script>
@endpush
