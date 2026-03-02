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

  // Use defaults if empty
  if (empty($extraordinary)) {
      $extraordinary = [];
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
              isset($landingPage) ? $landingPage->book_details_title : '',
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

          <!-- Extraordinary Title -->
          <x-forms.input name="book_details_extraordinary_title" label="Extraordinary Section Title" :value="old(
              'book_details_extraordinary_title',
              isset($landingPage) ? $landingPage->book_details_extraordinary_title : '',
          )" :error="$errors->first('book_details_extraordinary_title')"
                         placeholder="কী এই বইটিকে সত্যিই অসাধারণ করে তুলেছে?" help="Title for the extraordinary section" />

          <!-- Extraordinary Description -->
          <x-forms.rich-text name="book_details_extraordinary_description" label="Extraordinary Description" :value="old('book_details_extraordinary_description', isset($landingPage) ? $landingPage->book_details_extraordinary_description : '')" height="300px"
                             :error="$errors->first('book_details_extraordinary_description')"
                             help="Rich text description of what makes the book extraordinary. This will replace the points format." />

          <!-- Why Students Love Title -->
          <x-forms.input name="book_details_students_love_title" label="Why Students Love Section Title" :value="old(
              'book_details_students_love_title',
              isset($landingPage) ? $landingPage->book_details_students_love_title : '',
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
      // No JavaScript needed for description fields
    </script>
  @endpush
@endif
