@php
  $formAction = isset($landingPage)
      ? route('admin.landing-pages.update-partial', $landingPage)
      : route('admin.landing-pages.store-partial');
  $activeTab = request()->get('tab', 'basic');

  // Prepare data for JavaScript
  $extraordinary = [];
  if (isset($landingPage) && $landingPage->book_details_extraordinary) {
      $extraordinary = is_array($landingPage->book_details_extraordinary)
          ? $landingPage->book_details_extraordinary
          : json_decode($landingPage->book_details_extraordinary, true) ?? [];
  }

  // Default static content if empty
  $defaultExtraordinary = [
      '১। বৃহৎ কনটেন্ট । সর্বোচ্চ শেখা।',
      '২। ৫৭৬ প্রিমিয়াম পৃষ্ঠা',
      '৩। ১০৮ সহজবোধ্য লেসন',
      '৪। ১০৮০ বাস্তব জীবনের ডায়লগ',
      '৫। ১১৭৮ দৈনন্দিন ব্যবহৃত অভিব্যক্তি',
      '৬। ৩৫৩৪ স্পষ্ট উদাহরণ (ইংরেজি–বাংলা)',
      '৭। শতাধিক অনুশীলন',
      '৮। ৩টি শক্তিশালী পার্ট',
      '৯। উচ্চমানের পারটেক্স অফ-হোয়াইট পেপার',
      '১০। সম্পূর্ণ বইটিই বাংলায় ব্যাখ্যাসহ উপস্থাপিত',
  ];

  // Use defaults if empty
  if (empty($extraordinary)) {
      $extraordinary = $defaultExtraordinary;
  }
@endphp

@if ($activeTab === 'book-details')
  <div class="space-y-6">
    <x-card variant="elevated">
      <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
        <h2 class="text-lg font-medium text-gray-900">Details Section</h2>
        <p class="text-sm text-gray-500">Detailed information about the book, specialties, and why students love it</p>
      </div>

      <form action="{{ $formAction }}" method="POST" id="bookDetailsForm">
        @csrf
        @if (isset($landingPage))
          @method('PUT')
        @endif
        <input type="hidden" name="tab" value="book-details">

        <div class="space-y-6">
          <!-- Section Title -->
          <x-forms.input name="book_details_title" label="Section Title" :value="old(
              'book_details_title',
              isset($landingPage) ? $landingPage->book_details_title : 'বইটি সম্পর্কে যা না জানলেই নয়',
          )" :error="$errors->first('book_details_title')"
                         placeholder="বইটি সম্পর্কে যা না জানলেই নয়" help="Main heading for the book details section" />

          <!-- Description -->
          <x-forms.rich-text name="book_details_description" label="Description" :value="old('book_details_description', isset($landingPage) ? $landingPage->book_details_description : '')" height="300px"
                             :error="$errors->first('book_details_description')"
                             help="Main description about the book. This will be displayed in a highlighted box." />

          <!-- Book Specialties Title -->
          <x-forms.input name="book_details_specialties_title" label="Specialties Section Title" :value="old(
              'book_details_specialties_title',
              isset($landingPage) ? $landingPage->book_details_specialties_title : (isset($landingPage) && $landingPage->product_type === 'course' ? 'এই কোর্সের বিশেষত্ব:' : 'এই বইয়ের বিশেষত্ব:'),
          )" :error="$errors->first('book_details_specialties_title')"
                         placeholder="এই বইয়ের বিশেষত্ব:" help="Title for the specialties section" />

          <!-- Book Specialties Description -->
          <x-forms.rich-text name="book_details_specialties_description" label="Specialties Description" :value="old('book_details_specialties_description', isset($landingPage) ? $landingPage->book_details_specialties_description : '')" height="300px"
                             :error="$errors->first('book_details_specialties_description')"
                             help="Rich text description of the book's specialties. This will replace the list format." />

          <!-- Extraordinary Points -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">
                Extraordinary Points
              </label>
              <button type="button" id="add-extraordinary"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                + Add Point
              </button>
            </div>
            <p class="text-xs text-gray-500">Simple array of points that make the book extraordinary. These will be
              displayed in the left column.</p>

            <div id="extraordinary-container" class="space-y-2">
              @foreach (old('extraordinary', $extraordinary) as $index => $point)
                <div class="extraordinary-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                  <input type="text" name="extraordinary[{{ $index }}]"
                         value="{{ old("extraordinary.{$index}", $point) }}"
                         placeholder="e.g., ১। বৃহৎ কনটেন্ট । সর্বোচ্চ শেখা।"
                         class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                  <button type="button" class="remove-extraordinary text-red-600 hover:text-red-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              @endforeach
            </div>
            <x-forms.error :message="$errors->first('book_details_extraordinary')" />
          </div>

          <!-- Why Students Love Title -->
          <x-forms.input name="book_details_students_love_title" label="Why Students Love Section Title" :value="old(
              'book_details_students_love_title',
              isset($landingPage) ? $landingPage->book_details_students_love_title : 'কেন শিক্ষার্থীরা এই বইকে ভালোবাসেন',
          )" :error="$errors->first('book_details_students_love_title')"
                         placeholder="কেন শিক্ষার্থীরা এই বইকে ভালোবাসেন" help="Title for the 'Why Students Love' section" />

          <!-- Why Students Love Description -->
          <x-forms.rich-text name="book_details_students_love_description" label="Why Students Love Description" :value="old('book_details_students_love_description', isset($landingPage) ? $landingPage->book_details_students_love_description : '')" height="300px"
                             :error="$errors->first('book_details_students_love_description')"
                             help="Rich text description explaining why students love the book. This will replace the points format." />

          <!-- Submit Button -->
          <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
            <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=book-details"
               class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
              Cancel
            </a>
            <x-button type="submit" variant="primary" size="md">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ isset($landingPage) ? 'Update Book Details' : 'Save Book Details' }}
            </x-button>
          </div>
        </div>
      </form>
    </x-card>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        let extraordinaryIndex = {{ count($extraordinary) }};

        // Add Extraordinary Point
        $('#add-extraordinary').on('click', function() {
          const html = `
      <div class="extraordinary-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
        <input type="text" 
               name="extraordinary[${extraordinaryIndex}]" 
               placeholder="e.g., ১। বৃহৎ কনটেন্ট । সর্বোচ্চ শেখা।"
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        <button type="button" class="remove-extraordinary text-red-600 hover:text-red-700">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
    `;
          $('#extraordinary-container').append(html);
          extraordinaryIndex++;
        });

        // Remove Extraordinary Point
        $(document).on('click', '.remove-extraordinary', function() {
          if (confirm('Are you sure you want to remove this point?')) {
            $(this).closest('.extraordinary-item').remove();
          }
        });

        // Convert extraordinary array to JSON before form submission
        $('#bookDetailsForm').on('submit', function(e) {
          // Convert extraordinary array to JSON
          const extraordinary = [];
          $('.extraordinary-item input').each(function() {
            const value = $(this).val();
            if (value) {
              extraordinary.push(value);
            }
          });

          // Add hidden input with JSON value
          $('<input>').attr({
            type: 'hidden',
            name: 'book_details_extraordinary',
            value: JSON.stringify(extraordinary)
          }).appendTo(this);
        });
      });
    </script>
  @endpush
@endif
