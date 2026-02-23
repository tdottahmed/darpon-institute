@php
  $formAction = isset($landingPage)
      ? route('admin.landing-pages.update-partial', $landingPage)
      : route('admin.landing-pages.store-partial');
  $activeTab = request()->get('tab', 'basic');

  // Prepare data for JavaScript
  $featuresList = [];
  if (isset($landingPage) && $landingPage->features_list) {
      $featuresList = is_array($landingPage->features_list)
          ? $landingPage->features_list
          : json_decode($landingPage->features_list, true) ?? [];
  }

  $targetAudienceList = [];
  if (isset($landingPage) && $landingPage->target_audience_list) {
      $targetAudienceList = is_array($landingPage->target_audience_list)
          ? $landingPage->target_audience_list
          : json_decode($landingPage->target_audience_list, true) ?? [];
  }

  $gameChangerPoints = [];
  if (isset($landingPage) && $landingPage->game_changer_points) {
      $gameChangerPoints = is_array($landingPage->game_changer_points)
          ? $landingPage->game_changer_points
          : json_decode($landingPage->game_changer_points, true) ?? [];
  }

  // Default static content if empty
  $defaultFeaturesList = [
      [
          'title' => 'বইটির অসাধারণ কিছু বৈশিষ্ট্য',
          'items' => [
              ['text' => 'বাস্তবমুখী শেখা, শুধুই তত্ত্ব নয়: অনেক ইংরেজি বই শুধু গ্রামার বা নিয়ম শেখায়। এই বইটি শেখায় বাস্তব জীবনের কথোপকথন — মানুষ কীভাবে দৈনন্দিন জীবনে ইংরেজি বলে।', 'icon_color' => '#1a237e'],
              ['text' => 'এক বইয়ে সম্পূর্ণ শেখার উপকরণ: ১০৮টি পাঠ, ১,১৭৮টি এক্সপ্রেশন, ৩,৫৩৪টি উদাহরণ এবং ১,০৮০টি সংলাপসহ, শিক্ষার্থীর প্রয়োজনীয় সবকিছু এক জায়গায় — অভিব্যক্তি, শব্দভাণ্ডার, সংলাপ এবং অনুশীলন।', 'icon_color' => '#1a237e'],
              ['text' => 'সহজ বোঝার জন্য বাংলা অনুবাদ: প্রতিটি পাঠ বাংলায় অনূদিত, তাই শিক্ষার্থীরা সহজে এবং দ্রুত বুঝতে পারবে, এমনকি যারা শুরুতেই শিক্ষার্থী।', 'icon_color' => '#1a237e'],
              ['text' => 'অনুশীলনমুখী শেখার পদ্ধতি: বইটিতে প্রচুর অনুশীলন ও উদাহরণ রয়েছে, যা শিক্ষার্থীদের শেখা বিষয়গুলো তৎক্ষণাৎ প্রয়োগ করতে সাহায্য করে।', 'icon_color' => '#1a237e'],
              ['text' => 'আত্মবিশ্বাস গঠন: ধাপে ধাপে পাঠ ও সংলাপের মাধ্যমে, লাজুক বা দ্বিধাগ্রস্ত শিক্ষার্থীরাও ইংরেজিতে আসলেই আত্মবিশ্বাসীভাবে কথা বলতে শেখে।', 'icon_color' => '#1a237e'],
              ['text' => 'উচ্চমানের ও টেকসই: ৭০ gsm পারটেক্স অফ-হোয়াইট কাগজে ছাপা এবং হার্ডবোর্ডে বাঁধাই করা, বইটি দীর্ঘস্থায়ী এবং দৃষ্টিনন্দন, মানে এটি প্রিমিয়াম অনুভূতি দেয়।', 'icon_color' => '#1a237e'],
              ['text' => 'বিশেষ অফারটি এটিকে আরও আকর্ষণীয় করে তোলে: মূল্য ৳১২৮০ হলেও, প্রথম ৫০০ জন পাঠক পাবেন মাত্র ৳৭৫০, যা একটি দীর্ঘমেয়াদী দক্ষতায় বিনিয়োগের সেরা সুযোগ।', 'icon_color' => '#1a237e'],
          ],
      ],
  ];

  $defaultTargetAudienceList = [
      [
          'title' => 'বইটি মূলত কাদের জন্য?',
          'items' => [
              ['text' => 'SPOKEN ENGLISH IN REAL LIFE বইটি তৈরি করা হয়েছে এমন সকল শিক্ষার্থীদের জন্য, যারা— বাস্তব জীবনে সাবলীল ইংরেজিতে কথা বলতে চান স্কুল, কলেজ, ব্যবসা, অফিস, ভ্রমণ, ফোনে কথা বলা—সব পরিস্থিতিতে সহজে ইংরেজি ব্যবহার করতে পারবেন।', 'icon_color' => '#1565c0'],
              ['text' => 'ইংরেজি বলতে ভয় পান বা আত্মবিশ্বাসের অভাব অনুভব করেন: যারা কথা বলতে গিয়ে বারবার আটকে যান—এই বই তাদের জন্য অত্যন্ত উপযোগী।', 'icon_color' => '#1565c0'],
              ['text' => 'বেসিক জানেন, কিন্তু ব্যবহার করতে পারেন না: ব্যাকরণ জানা থাকলেও কথোপকথনে প্রয়োগ করতে পারেন না—তাদের জন্য এটি একটি প্র্যাকটিক্যাল গাইডবুক।', 'icon_color' => '#1565c0'],
              ['text' => 'Beginner থেকে Advance লেভেলের শিক্ষার্থী: সহজ ব্যাখ্যা, পর্যাপ্ত উদাহরণ ও বাস্তব ডায়ালগ—সব স্তরের শিক্ষার্থী সহজে শিখতে পারবেন।', 'icon_color' => '#1565c0'],
              ['text' => 'চাকরি, ইন্টারভিউ, প্রেজেন্টেশন বা অফিস কমিউনিকেশনের শিক্ষার্থী: Professional communication উন্নত করার জন্য বইটি অসাধারণ কার্যকর।', 'icon_color' => '#1565c0'],
              ['text' => 'English শিক্ষক ও প্রশিক্ষকরা: ক্লাসে ব্যবহারযোগ্য প্রচুর পরিমাণ ডায়লগ, বাক্য ও অনুশীলন রয়েছে।', 'icon_color' => '#1565c0'],
          ],
      ],
  ];

  $defaultGameChangerPoints = [
      '১। বাস্তব কথোপকথন',
      '২। ব্যবহারিক অভিব্যক্তি',
      '৩। স্পষ্ট উদাহরণ',
      '৪। দৈনন্দিন জীবনের পরিস্থিতি',
      '৫। কার্যকর অনুশীলন',
      '৬। সহজ বাংলা ব্যাখ্যা',
  ];

  // Use defaults if empty
  if (empty($featuresList)) {
      $featuresList = $defaultFeaturesList;
  }
  if (empty($targetAudienceList)) {
      $targetAudienceList = $defaultTargetAudienceList;
  }
  if (empty($gameChangerPoints)) {
      $gameChangerPoints = $defaultGameChangerPoints;
  }
@endphp

@if ($activeTab === 'features')
  <div class="space-y-6">
    <x-card variant="elevated">
      <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
        <h2 class="text-lg font-medium text-gray-900">Features Section</h2>
        <p class="text-sm text-gray-500">Book features, target audience, and game changer information</p>
      </div>

      <form action="{{ $formAction }}" method="POST" id="featuresForm">
        @csrf
        @if (isset($landingPage))
          @method('PUT')
        @endif
        <input type="hidden" name="tab" value="features">

        <div class="space-y-6">
          <!-- Features Title -->
          <x-forms.input name="features_list_title" label="Features Section Title" :value="old(
              'features_list_title',
              isset($landingPage) ? $landingPage->features_list_title : 'বইটির অসাধারণ কিছু বৈশিষ্ট্য',
          )" :error="$errors->first('features_list_title')"
                         placeholder="বইটির অসাধারণ কিছু বৈশিষ্ট্য" help="Title for the features section" />

          <!-- Features Description -->
          <x-forms.rich-text name="features_list_description" label="Features Description" :value="old('features_list_description', isset($landingPage) ? $landingPage->features_list_description : '')" height="300px"
                             :error="$errors->first('features_list_description')"
                             help="Rich text description of the book's features. This will replace the list format." />

          <!-- Target Audience Title -->
          <x-forms.input name="target_audience_list_title" label="Target Audience Section Title" :value="old(
              'target_audience_list_title',
              isset($landingPage) ? $landingPage->target_audience_list_title : 'বইটি মূলত কাদের জন্য?',
          )" :error="$errors->first('target_audience_list_title')"
                         placeholder="বইটি মূলত কাদের জন্য?" help="Title for the target audience section" />

          <!-- Target Audience Description -->
          <x-forms.rich-text name="target_audience_list_description" label="Target Audience Description" :value="old('target_audience_list_description', isset($landingPage) ? $landingPage->target_audience_list_description : '')" height="300px"
                             :error="$errors->first('target_audience_list_description')"
                             help="Rich text description of who the book is for. This will replace the list format." />

          <!-- Game Changer Section -->
          <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-4 text-base font-medium text-gray-900">Game Changer Section</h3>

            <x-forms.input name="game_changer_title" label="Game Changer Title"
                          :value="old('game_changer_title', isset($landingPage) ? $landingPage->game_changer_title : 'কেন এই বই একটি গেম চেঞ্জার')"
                          :error="$errors->first('game_changer_title')" placeholder="কেন এই বই একটি গেম চেঞ্জার"
                          help="Title for the game changer section" />

            <div class="mt-4">
              <x-forms.rich-text name="game_changer_description" label="Game Changer Description" :value="old('game_changer_description', isset($landingPage) ? $landingPage->game_changer_description : '')" height="300px"
                                 :error="$errors->first('game_changer_description')"
                                 help="Rich text description explaining why this book is a game changer. This will replace the points format." />
            </div>

            <div class="mt-4">
              <x-forms.textarea name="game_changer_conclusion" label="Game Changer Conclusion"
                              :value="old('game_changer_conclusion', isset($landingPage) ? $landingPage->game_changer_conclusion : 'ধাপে ধাপে এটি আপনাকে বেসিক থেকে অ্যাডভান্স-এ নিয়ে যায়—যাতে আপনি ইংরেজি সাবলীলভাবে, স্বাভাবিকভাবে এবং আত্মবিশ্বাসের সাথে বলতে পারেন।')"
                              rows="3" :error="$errors->first('game_changer_conclusion')"
                              placeholder="ধাপে ধাপে এটি আপনাকে বেসিক থেকে অ্যাডভান্স-এ নিয়ে যায়।"
                              help="Concluding text for the game changer section" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
            <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=features"
               class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
              Cancel
            </a>
            <x-button type="submit" variant="primary" size="md">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ isset($landingPage) ? 'Update Features' : 'Save Features' }}
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
