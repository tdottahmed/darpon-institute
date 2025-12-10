@props(['name', 'label', 'value' => '', 'required' => false, 'error' => null, 'help' => null, 'height' => '300px'])

@push('styles')
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endpush

<div class="space-y-1">
  @if ($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
      {{ $label }}
      @if ($required)
        <span class="text-red-500">*</span>
      @endif
    </label>
  @endif

  <div id="editor-{{ $name }}" style="height: {{ $height }};"></div>
  <input type="hidden" name="{{ $name }}" id="input-{{ $name }}" value="{{ old($name, $value) }}">

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
      var quill = new Quill('#editor-{{ $name }}', {
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
        document.getElementById('input-{{ $name }}').value = quill.root.innerHTML;
      });
    });
  </script>
@endpush
