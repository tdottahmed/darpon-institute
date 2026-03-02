@php
  $formAction = isset($landingPage) 
    ? route('admin.landing-pages.update-partial', $landingPage)
    : route('admin.landing-pages.store-partial');
  $activeTab = request()->get('tab', 'basic');

  // Prepare FAQ data
  $faqList = [];
  if (isset($landingPage) && $landingPage->faq_list) {
      $faqList = is_array($landingPage->faq_list)
          ? $landingPage->faq_list
          : json_decode($landingPage->faq_list, true) ?? [];
  }

  // Ensure we have at least one empty FAQ item
  if (empty($faqList)) {
      $faqList = [
          ['question' => '', 'answer' => '']
      ];
  }
@endphp

@if ($activeTab === 'faq')
  <div class="space-y-6">
    <x-card variant="elevated">
      <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
        <h2 class="text-lg font-medium text-gray-900">FAQ Section</h2>
        <p class="text-sm text-gray-500">Frequently Asked Questions configuration</p>
      </div>

      <form action="{{ $formAction }}" method="POST" id="faqForm">
        @csrf
        @if (isset($landingPage))
          @method('PUT')
        @endif
        <input type="hidden" name="tab" value="faq">

        <div class="space-y-6">
          <!-- FAQ Section Title -->
          <x-forms.input name="faq_section_title" label="FAQ Section Title" 
                         :value="old('faq_section_title', isset($landingPage) ? $landingPage->faq_section_title : 'Frequently Asked Questions')" 
                         :error="$errors->first('faq_section_title')"
                         placeholder="Frequently Asked Questions" 
                         help="Title displayed at the top of the FAQ section" />

          <!-- FAQ Items -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">FAQ Items</label>
              <button type="button" id="addFaqBtn" 
                      class="inline-flex items-center rounded-md border border-transparent bg-primary-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add FAQ
              </button>
            </div>

            <div id="faqItemsContainer" class="space-y-4">
              @foreach ($faqList as $index => $faq)
                <div class="faq-item rounded-lg border border-gray-200 bg-gray-50 p-4" data-index="{{ $index }}">
                  <div class="flex items-start justify-between mb-4">
                    <h4 class="text-sm font-medium text-gray-700">FAQ #{{ $index + 1 }}</h4>
                    <button type="button" class="remove-faq-btn inline-flex items-center rounded-md border border-red-300 bg-white px-2 py-1 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                      <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Remove
                    </button>
                  </div>
                  
                  <div class="space-y-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                      <input type="text" 
                             name="faq_list[{{ $index }}][question]" 
                             value="{{ old("faq_list.{$index}.question", $faq['question'] ?? '') }}"
                             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                             placeholder="Enter your question here">
                      <x-forms.error :message="$errors->first('faq_list.' . $index . '.question')" />
                    </div>
                    
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                      <textarea name="faq_list[{{ $index }}][answer]" 
                                rows="4"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Enter the answer here">{{ old("faq_list.{$index}.answer", $faq['answer'] ?? '') }}</textarea>
                      <x-forms.error :message="$errors->first('faq_list.' . $index . '.answer')" />
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
            <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=faq"
               class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
              Cancel
            </a>
            <x-button type="submit" variant="primary" size="md">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ isset($landingPage) ? 'Update FAQ' : 'Save FAQ' }}
            </x-button>
          </div>
        </div>
      </form>
    </x-card>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        let faqIndex = {{ count($faqList) }};

        // Add new FAQ item
        $('#addFaqBtn').on('click', function() {
          const faqHtml = `
            <div class="faq-item rounded-lg border border-gray-200 bg-gray-50 p-4" data-index="${faqIndex}">
              <div class="flex items-start justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-700">FAQ #${faqIndex + 1}</h4>
                <button type="button" class="remove-faq-btn inline-flex items-center rounded-md border border-red-300 bg-white px-2 py-1 text-sm font-medium text-red-700 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                  <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  Remove
                </button>
              </div>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                  <input type="text" 
                         name="faq_list[${faqIndex}][question]" 
                         value=""
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                         placeholder="Enter your question here">
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Answer</label>
                  <textarea name="faq_list[${faqIndex}][answer]" 
                            rows="4"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            placeholder="Enter the answer here"></textarea>
                </div>
              </div>
            </div>
          `;
          
          $('#faqItemsContainer').append(faqHtml);
          faqIndex++;
          updateFaqNumbers();
        });

        // Remove FAQ item
        $(document).on('click', '.remove-faq-btn', function() {
          const faqItems = $('.faq-item');
          if (faqItems.length > 1) {
            $(this).closest('.faq-item').remove();
            updateFaqNumbers();
          } else {
            alert('You must have at least one FAQ item.');
          }
        });

        // Update FAQ numbers
        function updateFaqNumbers() {
          $('.faq-item').each(function(index) {
            $(this).find('h4').text('FAQ #' + (index + 1));
            // Update input names to maintain sequential indexing
            const newIndex = index;
            $(this).find('input[name*="[question]"]').attr('name', `faq_list[${newIndex}][question]`);
            $(this).find('textarea[name*="[answer]"]').attr('name', `faq_list[${newIndex}][answer]`);
          });
        }
      });
    </script>
  @endpush
@endif
