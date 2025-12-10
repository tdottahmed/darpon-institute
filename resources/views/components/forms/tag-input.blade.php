@props([
    'name',
    'label',
    'value' => '',
    'required' => false,
    'error' => null,
    'help' => null,
    'placeholder' => 'Type and press Enter to add tags',
])

<div class="space-y-1" x-data="{
    tags: @js(is_array($value) ? $value : (is_string($value) && $value ? explode(',', $value) : [])),
    inputValue: '',
    addTag() {
        const tag = this.inputValue.trim();
        if (tag && !this.tags.includes(tag)) {
            this.tags.push(tag);
            this.inputValue = '';
            this.updateHiddenInput();
        }
    },
    removeTag(index) {
        this.tags.splice(index, 1);
        this.updateHiddenInput();
    },
    updateHiddenInput() {
        document.getElementById('{{ $name }}').value = this.tags.join(',');
    },
    handleKeydown(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.addTag();
        } else if (event.key === 'Backspace' && this.inputValue === '' && this.tags.length > 0) {
            this.removeTag(this.tags.length - 1);
        }
    }
}" x-init="updateHiddenInput()">
  @if ($label)
    <x-forms.label :for="$name" :required="$required">{{ $label }}</x-forms.label>
  @endif

  <div class="mt-1">
    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $name }}" id="{{ $name }}" :value="tags.join(',')">

    <!-- Tag Input Container -->
    <div
         class="min-h-[42px] rounded-lg border border-gray-300 bg-white px-3 py-2 shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-primary-500">
      <div class="flex flex-wrap items-center gap-2">
        <!-- Tags Display -->
        <template x-for="(tag, index) in tags" :key="index">
          <span
                class="inline-flex items-center gap-1.5 rounded-full bg-primary-100 px-3 py-1 text-sm font-medium text-primary-800">
            <span x-text="tag"></span>
            <button type="button" @click="removeTag(index)"
                    class="rounded-full text-primary-600 hover:bg-primary-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
              <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
              </svg>
            </button>
          </span>
        </template>

        <!-- Input Field -->
        <input type="text" x-model="inputValue" @keydown="handleKeydown($event)"
               :placeholder="tags.length === 0 ? '{{ $placeholder }}' : ''"
               class="flex-1 border-0 p-0 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-0">
      </div>
    </div>
  </div>

  <x-forms.error :message="$error" />
  <x-forms.help :message="$help" />
</div>
