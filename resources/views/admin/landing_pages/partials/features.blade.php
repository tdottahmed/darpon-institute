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
          <!-- Features List -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">
                Features List
              </label>
              <button type="button" id="add-feature-group"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                + Add Feature Group
              </button>
            </div>
            <p class="text-xs text-gray-500">List of book features. Each feature group has a title and items with text and icon_color.</p>

            <div id="features-list-container" class="space-y-4">
              @foreach (old('feature_groups', $featuresList) as $groupIndex => $group)
                <div class="feature-group rounded-lg border border-gray-200 bg-gray-50 p-4">
                  <div class="mb-4 flex items-start justify-between">
                    <div class="flex-1">
                      <input type="text" name="feature_groups[{{ $groupIndex }}][title]"
                             value="{{ old("feature_groups.{$groupIndex}.title", $group['title'] ?? '') }}"
                             placeholder="e.g., বইটির অসাধারণ কিছু বৈশিষ্ট্য"
                             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-medium">
                    </div>
                    <button type="button" class="ml-3 remove-feature-group text-red-600 hover:text-red-700">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                  <div class="space-y-2">
                    <div class="flex items-center justify-between">
                      <span class="text-xs font-medium text-gray-600">Feature Items</span>
                      <button type="button"
                              class="add-feature-item text-xs font-medium text-primary-600 hover:text-primary-700"
                              data-group-index="{{ $groupIndex }}">
                        + Add Item
                      </button>
                    </div>
                    <div class="feature-items space-y-2">
                      @foreach (old("feature_groups.{$groupIndex}.items", $group['items'] ?? []) as $itemIndex => $item)
                        <div class="feature-item flex items-start gap-2 rounded-md border border-gray-200 bg-white p-3">
                          <div class="flex-1 space-y-2">
                            <textarea name="feature_groups[{{ $groupIndex }}][items][{{ $itemIndex }}][text]" rows="2"
                                      placeholder="e.g., বাস্তবমুখী শেখা, শুধুই তত্ত্ব নয়"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old("feature_groups.{$groupIndex}.items.{$itemIndex}.text", $item['text'] ?? '') }}</textarea>
                            <input type="text" name="feature_groups[{{ $groupIndex }}][items][{{ $itemIndex }}][icon_color]"
                                   value="{{ old("feature_groups.{$groupIndex}.items.{$itemIndex}.icon_color", $item['icon_color'] ?? '#1a237e') }}"
                                   placeholder="Icon color (e.g., #1a237e)"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                          </div>
                          <button type="button" class="remove-feature-item text-red-600 hover:text-red-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <x-forms.error :message="$errors->first('features_list')" />
          </div>

          <!-- Target Audience List -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700">
                Target Audience List
              </label>
              <button type="button" id="add-audience-group"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                + Add Audience Group
              </button>
            </div>
            <p class="text-xs text-gray-500">List describing who the book is for. Structure is similar to features list.</p>

            <div id="audience-list-container" class="space-y-4">
              @foreach (old('audience_groups', $targetAudienceList) as $groupIndex => $group)
                <div class="audience-group rounded-lg border border-gray-200 bg-gray-50 p-4">
                  <div class="mb-4 flex items-start justify-between">
                    <div class="flex-1">
                      <input type="text" name="audience_groups[{{ $groupIndex }}][title]"
                             value="{{ old("audience_groups.{$groupIndex}.title", $group['title'] ?? '') }}"
                             placeholder="e.g., বইটি মূলত কাদের জন্য?"
                             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-medium">
                    </div>
                    <button type="button" class="ml-3 remove-audience-group text-red-600 hover:text-red-700">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                  <div class="space-y-2">
                    <div class="flex items-center justify-between">
                      <span class="text-xs font-medium text-gray-600">Audience Items</span>
                      <button type="button"
                              class="add-audience-item text-xs font-medium text-primary-600 hover:text-primary-700"
                              data-group-index="{{ $groupIndex }}">
                        + Add Item
                      </button>
                    </div>
                    <div class="audience-items space-y-2">
                      @foreach (old("audience_groups.{$groupIndex}.items", $group['items'] ?? []) as $itemIndex => $item)
                        <div class="audience-item flex items-start gap-2 rounded-md border border-gray-200 bg-white p-3">
                          <div class="flex-1 space-y-2">
                            <textarea name="audience_groups[{{ $groupIndex }}][items][{{ $itemIndex }}][text]" rows="2"
                                      placeholder="e.g., যারা বাস্তব জীবনে সাবলীল ইংরেজিতে কথা বলতে চান"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old("audience_groups.{$groupIndex}.items.{$itemIndex}.text", $item['text'] ?? '') }}</textarea>
                            <input type="text" name="audience_groups[{{ $groupIndex }}][items][{{ $itemIndex }}][icon_color]"
                                   value="{{ old("audience_groups.{$groupIndex}.items.{$itemIndex}.icon_color", $item['icon_color'] ?? '#1565c0') }}"
                                   placeholder="Icon color (e.g., #1565c0)"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                          </div>
                          <button type="button" class="remove-audience-item text-red-600 hover:text-red-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
            <x-forms.error :message="$errors->first('target_audience_list')" />
          </div>

          <!-- Game Changer Section -->
          <div class="border-t border-gray-200 pt-6">
            <h3 class="mb-4 text-base font-medium text-gray-900">Game Changer Section</h3>

            <x-forms.input name="game_changer_title" label="Game Changer Title"
                          :value="old('game_changer_title', isset($landingPage) ? $landingPage->game_changer_title : 'কেন এই বই একটি গেম চেঞ্জার')"
                          :error="$errors->first('game_changer_title')" placeholder="কেন এই বই একটি গেম চেঞ্জার"
                          help="Title for the game changer section" />

            <div class="mt-4 space-y-4">
              <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-gray-700">Game Changer Points</label>
                <button type="button" id="add-game-changer-point"
                        class="text-sm font-medium text-primary-600 hover:text-primary-700">
                  + Add Point
                </button>
              </div>
              <p class="text-xs text-gray-500">Simple array of key points that make this book a game changer.</p>

              <div id="game-changer-points-container" class="space-y-2">
                @foreach (old('game_changer_points_array', $gameChangerPoints) as $index => $point)
                  <div class="game-changer-point-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
                    <input type="text" name="game_changer_points_array[{{ $index }}]"
                           value="{{ old("game_changer_points_array.{$index}", $point) }}"
                           placeholder="e.g., ১। বাস্তব কথোপকথন"
                           class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    <button type="button" class="remove-game-changer-point text-red-600 hover:text-red-700">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                    </button>
                  </div>
                @endforeach
              </div>
              <x-forms.error :message="$errors->first('game_changer_points')" />
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
      $(document).ready(function() {
        let featureGroupIndex = {{ count($featuresList) }};
        let audienceGroupIndex = {{ count($targetAudienceList) }};
        let gameChangerPointIndex = {{ count($gameChangerPoints) }};

        // Add Feature Group
        $('#add-feature-group').on('click', function() {
          const html = `
            <div class="feature-group rounded-lg border border-gray-200 bg-gray-50 p-4">
              <div class="mb-4 flex items-start justify-between">
                <div class="flex-1">
                  <input type="text" name="feature_groups[${featureGroupIndex}][title]"
                         placeholder="e.g., বইটির অসাধারণ কিছু বৈশিষ্ট্য"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-medium">
                </div>
                <button type="button" class="ml-3 remove-feature-group text-red-600 hover:text-red-700">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-medium text-gray-600">Feature Items</span>
                  <button type="button" class="add-feature-item text-xs font-medium text-primary-600 hover:text-primary-700" data-group-index="${featureGroupIndex}">
                    + Add Item
                  </button>
                </div>
                <div class="feature-items space-y-2"></div>
              </div>
            </div>
          `;
          $('#features-list-container').append(html);
          featureGroupIndex++;
        });

        // Remove Feature Group
        $(document).on('click', '.remove-feature-group', function() {
          if (confirm('Are you sure you want to remove this feature group?')) {
            $(this).closest('.feature-group').remove();
          }
        });

        // Add Feature Item
        $(document).on('click', '.add-feature-item', function() {
          const groupIndex = $(this).data('group-index');
          const itemsContainer = $(this).closest('.feature-group').find('.feature-items');
          const itemIndex = itemsContainer.find('.feature-item').length;
          const html = `
            <div class="feature-item flex items-start gap-2 rounded-md border border-gray-200 bg-white p-3">
              <div class="flex-1 space-y-2">
                <textarea name="feature_groups[${groupIndex}][items][${itemIndex}][text]" rows="2"
                          placeholder="e.g., বাস্তবমুখী শেখা, শুধুই তত্ত্ব নয়"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                <input type="text" name="feature_groups[${groupIndex}][items][${itemIndex}][icon_color]"
                       value="#1a237e"
                       placeholder="Icon color (e.g., #1a237e)"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
              </div>
              <button type="button" class="remove-feature-item text-red-600 hover:text-red-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          `;
          itemsContainer.append(html);
        });

        // Remove Feature Item
        $(document).on('click', '.remove-feature-item', function() {
          if (confirm('Are you sure you want to remove this item?')) {
            $(this).closest('.feature-item').remove();
          }
        });

        // Add Audience Group
        $('#add-audience-group').on('click', function() {
          const html = `
            <div class="audience-group rounded-lg border border-gray-200 bg-gray-50 p-4">
              <div class="mb-4 flex items-start justify-between">
                <div class="flex-1">
                  <input type="text" name="audience_groups[${audienceGroupIndex}][title]"
                         placeholder="e.g., বইটি মূলত কাদের জন্য?"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm font-medium">
                </div>
                <button type="button" class="ml-3 remove-audience-group text-red-600 hover:text-red-700">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </div>
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-medium text-gray-600">Audience Items</span>
                  <button type="button" class="add-audience-item text-xs font-medium text-primary-600 hover:text-primary-700" data-group-index="${audienceGroupIndex}">
                    + Add Item
                  </button>
                </div>
                <div class="audience-items space-y-2"></div>
              </div>
            </div>
          `;
          $('#audience-list-container').append(html);
          audienceGroupIndex++;
        });

        // Remove Audience Group
        $(document).on('click', '.remove-audience-group', function() {
          if (confirm('Are you sure you want to remove this audience group?')) {
            $(this).closest('.audience-group').remove();
          }
        });

        // Add Audience Item
        $(document).on('click', '.add-audience-item', function() {
          const groupIndex = $(this).data('group-index');
          const itemsContainer = $(this).closest('.audience-group').find('.audience-items');
          const itemIndex = itemsContainer.find('.audience-item').length;
          const html = `
            <div class="audience-item flex items-start gap-2 rounded-md border border-gray-200 bg-white p-3">
              <div class="flex-1 space-y-2">
                <textarea name="audience_groups[${groupIndex}][items][${itemIndex}][text]" rows="2"
                          placeholder="e.g., যারা বাস্তব জীবনে সাবলীল ইংরেজিতে কথা বলতে চান"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                <input type="text" name="audience_groups[${groupIndex}][items][${itemIndex}][icon_color]"
                       value="#1565c0"
                       placeholder="Icon color (e.g., #1565c0)"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
              </div>
              <button type="button" class="remove-audience-item text-red-600 hover:text-red-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          `;
          itemsContainer.append(html);
        });

        // Remove Audience Item
        $(document).on('click', '.remove-audience-item', function() {
          if (confirm('Are you sure you want to remove this item?')) {
            $(this).closest('.audience-item').remove();
          }
        });

        // Add Game Changer Point
        $('#add-game-changer-point').on('click', function() {
          const html = `
            <div class="game-changer-point-item flex items-center gap-2 rounded-lg border border-gray-200 bg-white p-3">
              <input type="text" name="game_changer_points_array[${gameChangerPointIndex}]"
                     placeholder="e.g., ১। বাস্তব কথোপকথন"
                     class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
              <button type="button" class="remove-game-changer-point text-red-600 hover:text-red-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
              </button>
            </div>
          `;
          $('#game-changer-points-container').append(html);
          gameChangerPointIndex++;
        });

        // Remove Game Changer Point
        $(document).on('click', '.remove-game-changer-point', function() {
          if (confirm('Are you sure you want to remove this point?')) {
            $(this).closest('.game-changer-point-item').remove();
          }
        });

        // Convert arrays to JSON before form submission
        $('#featuresForm').on('submit', function(e) {
          // Convert feature groups to JSON
          const featuresList = [];
          $('.feature-group').each(function() {
            const title = $(this).find('input[name*="[title]"]').val();
            const items = [];
            $(this).find('.feature-item').each(function() {
              const text = $(this).find('textarea[name*="[text]"]').val();
              const iconColor = $(this).find('input[name*="[icon_color]"]').val();
              if (text) {
                items.push({
                  text: text,
                  icon_color: iconColor || '#1a237e'
                });
              }
            });
            if (title || items.length > 0) {
              featuresList.push({
                title: title || '',
                items: items
              });
            }
          });

          // Convert audience groups to JSON
          const targetAudienceList = [];
          $('.audience-group').each(function() {
            const title = $(this).find('input[name*="[title]"]').val();
            const items = [];
            $(this).find('.audience-item').each(function() {
              const text = $(this).find('textarea[name*="[text]"]').val();
              const iconColor = $(this).find('input[name*="[icon_color]"]').val();
              if (text) {
                items.push({
                  text: text,
                  icon_color: iconColor || '#1565c0'
                });
              }
            });
            if (title || items.length > 0) {
              targetAudienceList.push({
                title: title || '',
                items: items
              });
            }
          });

          // Convert game changer points array to JSON
          const gameChangerPoints = [];
          $('.game-changer-point-item input').each(function() {
            const value = $(this).val();
            if (value) {
              gameChangerPoints.push(value);
            }
          });

          // Add hidden inputs with JSON values
          $('<input>').attr({
            type: 'hidden',
            name: 'features_list',
            value: JSON.stringify(featuresList)
          }).appendTo(this);

          $('<input>').attr({
            type: 'hidden',
            name: 'target_audience_list',
            value: JSON.stringify(targetAudienceList)
          }).appendTo(this);

          $('<input>').attr({
            type: 'hidden',
            name: 'game_changer_points',
            value: JSON.stringify(gameChangerPoints)
          }).appendTo(this);
        });
      });
    </script>
  @endpush
@endif
