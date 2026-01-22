@php
  $formAction = isset($landingPage) 
    ? route('admin.landing-pages.update-partial', $landingPage)
    : route('admin.landing-pages.store-partial');
  $activeTab = request()->get('tab', 'basic');
@endphp

@if ($activeTab === 'author')
  <div class="space-y-6">
    <x-card variant="elevated">
      <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
        <h2 class="text-lg font-medium text-gray-900">Author Information</h2>
        <p class="text-sm text-gray-500">Manage author details displayed on the landing page</p>
      </div>

      <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($landingPage))
          @method('PUT')
        @endif
        <input type="hidden" name="tab" value="author">

        <div class="space-y-6">
          @php
            // Default author information
            $defaultAuthorBadge = 'About The Author';
            $defaultAuthorName = 'মো: শফিকুল ইসলাম';
            $defaultAuthorTitle = 'প্রতিষ্ঠাতা ও পরিচালক, দর্পণ ইংলিশ টিচিং জোন';
            $defaultAuthorDescription = 'মো: শফিকুল ইসলাম একজন অভিজ্ঞ ও গবেষণাশীল ইংরেজি শিক্ষক, যার শিক্ষকতার বয়স ২৫ বছরেরও বেশি। তিনি আধুনিক পদ্ধতিতে Spoken English, Written English, Phonetics ও Academic English শেখানোর ক্ষেত্রে সুনাম অর্জন করেছেন।

ইংরেজি ভাষার ওপর ১৬ বছর ধরে গবেষণা করছেন এবং এখন পর্যন্ত ৩০টিরও বেশি বই রচনা করেছেন। \'Spoken English In Real Life\' তার প্রথম প্রকাশিত বই। তাঁর বইগুলো সহজবোধ্য উপস্থাপনা, বাস্তব উদাহরণ ও শিক্ষার্থী-বান্ধব স্টাইলে সমৃদ্ধ, যা ইংরেজি শেখাকে আরও সহজ ও কার্যকর করে তোলে। ইংরেজি শিক্ষাকে সবার জন্য সহজ ও আনন্দময় করাই তাঁর মূল লক্ষ্য।';
            
            // Get values with defaults
            $authorBadge = old('author_badge', isset($landingPage) && $landingPage->author_badge ? $landingPage->author_badge : $defaultAuthorBadge);
            $authorName = old('author_name', isset($landingPage) && $landingPage->author_name ? $landingPage->author_name : $defaultAuthorName);
            $authorTitle = old('author_title', isset($landingPage) && $landingPage->author_title ? $landingPage->author_title : $defaultAuthorTitle);
            $authorDescription = old('author_description', isset($landingPage) && $landingPage->author_description ? $landingPage->author_description : $defaultAuthorDescription);
          @endphp

          <!-- Author Badge -->
          <x-forms.input name="author_badge" label="Author Badge Text" :value="$authorBadge" :error="$errors->first('author_badge')"
                         placeholder="About The Author" help="Badge text displayed above author name" />

          <!-- Author Name (Bengali) -->
          <x-forms.input name="author_name" label="Author Name (Bengali)" :value="$authorName" :error="$errors->first('author_name')"
                         placeholder="মো: শফিকুল ইসলাম" help="Author's name in Bengali" />

          <!-- Author Title/Position (Bengali) -->
          <x-forms.input name="author_title" label="Author Title/Position (Bengali)" :value="$authorTitle" :error="$errors->first('author_title')"
                         placeholder="প্রতিষ্ঠাতা ও পরিচালক, দর্পণ ইংলিশ টিচিং জোন" help="Author's title or position in Bengali" />

          <!-- Author Description (Bengali) -->
          <x-forms.rich-text name="author_description" label="Author Description (Bengali)" :value="$authorDescription" height="300px"
                             :error="$errors->first('author_description')"
                             help="Detailed description about the author in Bengali. This will be displayed in the author section." />

          <!-- Author Image -->
          <x-forms.image-uploader name="author_image" label="Author Image" 
                                  :value="old('author_image', isset($landingPage) && $landingPage->author_image ? Storage::url($landingPage->author_image) : '')"
                                  accept="image/*" maxSize="2MB" 
                                  :error="$errors->first('author_image')"
                                  help="Author's profile image. Recommended size: 350x350px or larger square image." />
          
          @if(isset($landingPage) && $landingPage->author_image)
            <div class="flex items-center gap-2">
              <input type="checkbox" name="author_image_remove" id="author_image_remove" value="1" 
                     class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <label for="author_image_remove" class="text-sm text-gray-700">Remove current image</label>
            </div>
          @endif

          <!-- Submit Button -->
          <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
            <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=author"
               class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
              Cancel
            </a>
            <x-button type="submit" variant="primary" size="md">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ isset($landingPage) ? 'Update Author Info' : 'Save Author Info' }}
            </x-button>
          </div>
        </div>
      </form>
    </x-card>
  </div>
@endif
