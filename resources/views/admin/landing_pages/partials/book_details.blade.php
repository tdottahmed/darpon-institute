@php
  $formAction = isset($landingPage)
      ? route('admin.landing-pages.update-partial', $landingPage)
      : route('admin.landing-pages.store-partial');
  $activeTab = request()->get('tab', 'basic');

  // Prepare data for JavaScript
  $specialties = [];
  if (isset($landingPage) && $landingPage->book_details_specialties) {
      $specialties = is_array($landingPage->book_details_specialties)
          ? $landingPage->book_details_specialties
          : json_decode($landingPage->book_details_specialties, true) ?? [];
  }

  $extraordinary = [];
  if (isset($landingPage) && $landingPage->book_details_extraordinary) {
      $extraordinary = is_array($landingPage->book_details_extraordinary)
          ? $landingPage->book_details_extraordinary
          : json_decode($landingPage->book_details_extraordinary, true) ?? [];
  }

  $studentsLove = [];
  if (isset($landingPage) && $landingPage->book_details_students_love) {
      $studentsLove = is_array($landingPage->book_details_students_love)
          ? $landingPage->book_details_students_love
          : json_decode($landingPage->book_details_students_love, true) ?? [];
  }

  // Default static content if empty
  $defaultSpecialties = [
      [
          'title' => '১০৮ টি লেসন',
          'description' =>
              'Beginner থেকে Advanced পর্যন্ত: প্রতিটি লেসন বাস্তব জীবনের নির্দিষ্ট পরিস্থিতির উপর সাজানো—যেমন দোকান, বাজার, ভ্রমণ, স্কুল, অফিস, ফোনকল, রেস্টুরেন্ট, হোটেল, চিকিৎসা, অ্যাপয়েন্টমেন্ট, ইত্যাদি।',
      ],
      [
          'title' => '১১৭৮টি প্রয়োজনীয় অভিব্যক্তি (Expressions)',
          'description' =>
              'দৈনন্দিন কথোপকথনে ব্যবহৃত সব গুরুত্বপূর্ণ এক্সপ্রেশন যুক্ত করা হয়েছে—যা ইংরেজি বলার ভিত্তি তৈরি করে।',
      ],
      [
          'title' => '৩৫৩৪টি বাস্তব উদাহরণ বাক্য',
          'description' =>
              'বইটির প্রতিটি বিষয় পরিষ্কারভাবে বুঝিয়ে দিতে প্রচুর উদাহরণ দেওয়া হয়েছে, যাতে শেখা সহজ হয় ও মনে থাকে।',
      ],
      [
          'title' => '১০৮০টি বাস্তব জীবনের সংলাপ (Dialogues)',
          'description' => 'যা আপনাকে সত্যিকারের ইংরেজি ব্যবহারের অভিজ্ঞতা দেবে—একাই অনুশীলন করার জন্য পারফেক্ট।',
      ],
      [
          'title' => 'অসংখ্য অনুশীলন (Exercises)',
          'description' =>
              'প্রতিটি লেসনের শেষে পর্যাপ্ত অনুশীলন, যাতে আপনি শেখা বিষয়টি ব্যবহার করে আত্মবিশ্বাস বাড়াতে পারেন।',
      ],
  ];

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

  $defaultStudentsLove = [
      '১। দৈনন্দিন জীবনের সব পরিস্থিতি—বাড়ি, স্কুল, অফিস, বাজার, ভ্রমণ, ফোনকথা, মিটিং, প্রেজেন্টেশন—সবকিছুই কভার করা হয়েছে',
      '২। মুখস্থ না করে স্বাভাবিকভাবে বলার উপায় শেখায়',
      '৩। সহজ বাংলা ব্যাখ্যার মাধ্যমে আত্মবিশ্বাস বৃদ্ধি করে',
      '৪। আধুনিক শব্দভান্ডার, স্মার্ট এক্সপ্রেশন এবং বাস্তব কথোপকথনের প্যাটার্ন অন্তর্ভুক্ত',
      '৫। স্ব-শিক্ষা, কোচিং সেন্টার এবং পেশাগত ট্রেনিং—সবক্ষেত্রেই উপযোগী',
      '৬। বেসিক থেকে অ্যাডভান্স লেভেল পর্যন্ত সবার জন্য',
      '৭। কথোপকথনগুলো বাস্তবসম্মত, প্রাসঙ্গিক এবং সহজে ব্যবহারযোগ্য',
  ];

  // Use defaults if empty
  if (empty($specialties)) {
      $specialties = $defaultSpecialties;
  }
  if (empty($extraordinary)) {
      $extraordinary = $defaultExtraordinary;
  }
  if (empty($studentsLove)) {
      $studentsLove = $defaultStudentsLove;
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

          <!-- Book Specialties -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">
                Specialties
              </label>
              <button type="button" id="add-specialty"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                + Add Specialty
              </button>
            </div>
            <p class="text-xs text-gray-500">List of key specialties/features of the book. Each item should have a title
              and description.</p>

            <div id="specialties-container" class="space-y-3">
              @foreach (old('specialties', $specialties) as $index => $specialty)
                <div class="specialty-item rounded-lg border border-gray-200 bg-white p-4">
                  <div class="mb-3 flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-700">Specialty {{ $index + 1 }}</span>
                    <button type="button" class="remove-specialty text-red-600 hover:text-red-700">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                  <div class="space-y-3">
                    <input type="text" name="specialties[{{ $index }}][title]"
                           value="{{ old("specialties.{$index}.title", $specialty['title'] ?? '') }}"
                           placeholder="e.g., ১০৮ টি লেসন"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <textarea name="specialties[{{ $index }}][description]" rows="2" placeholder="e.g., বিস্তারিত বর্ণনা এখানে"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old("specialties.{$index}.description", $specialty['description'] ?? '') }}</textarea>
                  </div>
                </div>
              @endforeach
            </div>
            <x-forms.error :message="$errors->first('book_details_specialties')" />
          </div>

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

          <!-- Why Students Love -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">
                Why Students Love
              </label>
              <button type="button" id="add-students-love"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                + Add Point
              </button>
            </div>
            <p class="text-xs text-gray-500">Simple array of reasons why students love the book. These will be displayed
              in the right column.</p>

            <div id="students-love-container" class="space-y-2">
              @foreach (old('students_love', $studentsLove) as $index => $point)
                <div class="students-love-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                  <input type="text" name="students_love[{{ $index }}]"
                         value="{{ old("students_love.{$index}", $point) }}"
                         placeholder="e.g., ১। দৈনন্দিন জীবনের সব পরিস্থিতি"
                         class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                  <button type="button" class="remove-students-love text-red-600 hover:text-red-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              @endforeach
            </div>
            <x-forms.error :message="$errors->first('book_details_students_love')" />
          </div>

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
        let specialtyIndex = {{ count($specialties) }};
        let extraordinaryIndex = {{ count($extraordinary) }};
        let studentsLoveIndex = {{ count($studentsLove) }};

        // Add Specialty
        $('#add-specialty').on('click', function() {
          const html = `
      <div class="specialty-item rounded-lg border border-gray-200 bg-white p-4">
        <div class="flex items-start justify-between mb-3">
          <span class="text-sm font-medium text-gray-700">Specialty ${specialtyIndex + 1}</span>
          <button type="button" class="remove-specialty text-red-600 hover:text-red-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
          </button>
        </div>
        <div class="space-y-3">
          <input type="text" 
                 name="specialties[${specialtyIndex}][title]" 
                 placeholder="e.g., ১০৮ টি লেসন"
                 class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
          <textarea name="specialties[${specialtyIndex}][description]" 
                    rows="2"
                    placeholder="e.g., বিস্তারিত বর্ণনা এখানে"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
        </div>
      </div>
    `;
          $('#specialties-container').append(html);
          specialtyIndex++;
        });

        // Remove Specialty
        $(document).on('click', '.remove-specialty', function() {
          if (confirm('Are you sure you want to remove this specialty?')) {
            $(this).closest('.specialty-item').remove();
          }
        });

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

        // Add Students Love Point
        $('#add-students-love').on('click', function() {
          const html = `
      <div class="students-love-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
        <input type="text" 
               name="students_love[${studentsLoveIndex}]" 
               placeholder="e.g., ১। দৈনন্দিন জীবনের সব পরিস্থিতি"
               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
        <button type="button" class="remove-students-love text-red-600 hover:text-red-700">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
    `;
          $('#students-love-container').append(html);
          studentsLoveIndex++;
        });

        // Remove Students Love Point
        $(document).on('click', '.remove-students-love', function() {
          if (confirm('Are you sure you want to remove this point?')) {
            $(this).closest('.students-love-item').remove();
          }
        });

        // Convert arrays to JSON before form submission
        $('#bookDetailsForm').on('submit', function(e) {
          // Convert specialties array to JSON
          const specialties = [];
          $('.specialty-item').each(function() {
            const title = $(this).find('input[name*="[title]"]').val();
            const description = $(this).find('textarea[name*="[description]"]').val();
            if (title || description) {
              specialties.push({
                title: title || '',
                description: description || ''
              });
            }
          });

          // Convert extraordinary array to JSON
          const extraordinary = [];
          $('.extraordinary-item input').each(function() {
            const value = $(this).val();
            if (value) {
              extraordinary.push(value);
            }
          });

          // Convert students_love array to JSON
          const studentsLove = [];
          $('.students-love-item input').each(function() {
            const value = $(this).val();
            if (value) {
              studentsLove.push(value);
            }
          });

          // Add hidden inputs with JSON values
          $('<input>').attr({
            type: 'hidden',
            name: 'book_details_specialties',
            value: JSON.stringify(specialties)
          }).appendTo(this);

          $('<input>').attr({
            type: 'hidden',
            name: 'book_details_extraordinary',
            value: JSON.stringify(extraordinary)
          }).appendTo(this);

          $('<input>').attr({
            type: 'hidden',
            name: 'book_details_students_love',
            value: JSON.stringify(studentsLove)
          }).appendTo(this);
        });
      });
    </script>
  @endpush
@endif
