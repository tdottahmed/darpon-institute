<!-- Book Details Tab -->
<div x-show="activeTab === 'book-details'" class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Book Details Section</h2>
      <p class="text-sm text-gray-500">Detailed information about the book, specialties, and why students love it</p>
    </div>

    <div class="space-y-6">
      <x-forms.input name="book_details_title" label="Section Title" 
                     :value="old('book_details_title', isset($landingPage) ? $landingPage->book_details_title : '')" 
                     :error="$errors->first('book_details_title')"
                     placeholder="বইটি সম্পর্কে যা না জানলেই নয়" 
                     help="Main heading for the book details section" />
      
      <x-forms.rich-text name="book_details_description" label="Description" 
                         :value="old('book_details_description', isset($landingPage) ? $landingPage->book_details_description : '')" 
                         height="300px"
                         :error="$errors->first('book_details_description')" 
                         help="Main description about the book. This will be displayed in a highlighted box." />

      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Book Specialties (JSON Format)</label>
        <p class="text-xs text-gray-500 mb-2">List of key specialties/features of the book. Each item should have a title and description.</p>
        <textarea name="book_details_specialties" rows="12"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='[
  {
    "title": "১০৮ টি লেসন",
    "description": "বিস্তারিত বর্ণনা এখানে"
  },
  {
    "title": "১১৭৮টি প্রয়োজনীয় অভিব্যক্তি",
    "description": "বিস্তারিত বর্ণনা এখানে"
  }
]'>{{ old('book_details_specialties', isset($landingPage) && $landingPage->book_details_specialties ? json_encode($landingPage->book_details_specialties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        <x-forms.error :message="$errors->first('book_details_specialties')" />
      </div>

      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Extraordinary Points (JSON Array)</label>
        <p class="text-xs text-gray-500 mb-2">Simple array of points that make the book extraordinary. These will be displayed in the left column.</p>
        <textarea name="book_details_extraordinary" rows="8"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='[
  "১। বৃহৎ কনটেন্ট । সর্বোচ্চ শেখা।",
  "২। ৫৭৬ প্রিমিয়াম পৃষ্ঠা",
  "৩। ১০৮ সহজবোধ্য লেসন"
]'>{{ old('book_details_extraordinary', isset($landingPage) && $landingPage->book_details_extraordinary ? json_encode($landingPage->book_details_extraordinary, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        <x-forms.error :message="$errors->first('book_details_extraordinary')" />
      </div>

      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Why Students Love (JSON Array)</label>
        <p class="text-xs text-gray-500 mb-2">Simple array of reasons why students love the book. These will be displayed in the right column.</p>
        <textarea name="book_details_students_love" rows="8"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='[
  "১। দৈনন্দিন জীবনের সব পরিস্থিতি",
  "২। মুখস্থ না করে স্বাভাবিকভাবে বলার উপায় শেখায়",
  "৩। সহজ বাংলা ব্যাখ্যার মাধ্যমে আত্মবিশ্বাস বৃদ্ধি করে"
]'>{{ old('book_details_students_love', isset($landingPage) && $landingPage->book_details_students_love ? json_encode($landingPage->book_details_students_love, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
        <x-forms.error :message="$errors->first('book_details_students_love')" />
      </div>
    </div>
  </x-card>
</div>

