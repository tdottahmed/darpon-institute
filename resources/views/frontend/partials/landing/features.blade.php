@php
  // Get dynamic data from landing page
  $featuresList = [];
  if ($landingPage->features_list) {
      $featuresList = is_array($landingPage->features_list)
          ? $landingPage->features_list
          : json_decode($landingPage->features_list, true) ?? [];
  }

  $targetAudienceList = [];
  if ($landingPage->target_audience_list) {
      $targetAudienceList = is_array($landingPage->target_audience_list)
          ? $landingPage->target_audience_list
          : json_decode($landingPage->target_audience_list, true) ?? [];
  }

  $gameChangerTitle = $landingPage->game_changer_title ?? 'কেন এই বই একটি গেম চেঞ্জার';
  $gameChangerPoints = [];
  if ($landingPage->game_changer_points) {
      $gameChangerPoints = is_array($landingPage->game_changer_points)
          ? $landingPage->game_changer_points
          : json_decode($landingPage->game_changer_points, true) ?? [];
  }
  $gameChangerConclusion = $landingPage->game_changer_conclusion ?? 'ধাপে ধাপে এটি আপনাকে বেসিক থেকে অ্যাডভান্স-এ নিয়ে যায়—যাতে আপনি ইংরেজি সাবলীলভাবে, স্বাভাবিকভাবে এবং আত্মবিশ্বাসের সাথে বলতে পারেন।';

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

<section class="features-section section" style="background-color: #073050;">
  <div class="container-narrow">
    <div class="features-grid" style="display: grid; grid-template-columns: 1fr">

      <!-- Book Features Column -->
      @if(!empty($featuresList))
      @foreach($featuresList as $featureGroup)
      <div class="feature-column">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $featureGroup['title'] ?? 'বইটির অসাধারণ কিছু বৈশিষ্ট্য:' }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
          @foreach($featureGroup['items'] ?? [] as $item)
            <p class="bengali-text" style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem; margin-bottom: 15px;">
              @if(isset($item['text']))
                @php
                  $textParts = explode(':', $item['text'], 2);
                  $boldPart = $textParts[0] ?? '';
                  $descriptionPart = $textParts[1] ?? '';
                @endphp
                @if($descriptionPart)
                  {{ $boldPart }}: {{ $descriptionPart }}
                @else
                  {{ $item['text'] }}
                @endif
              @endif
            </p>
          @endforeach
        </div>

        <div style="text-align: center; margin-top: 40px;">
          <button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
                  style="background-color: #1A237E; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                  onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            অর্ডার করুন
          </button>
        </div>
      </div>
      @endforeach
      @endif

      <!-- Target Audience Column -->
      {{-- @if(!empty($targetAudienceList))
      @foreach($targetAudienceList as $audienceGroup)
      <div class="feature-column">
        <h2 class="bengali-text feature-heading"
            style="color: var(--primary-color); margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; border-bottom: 2px solid var(--accent-color); padding-bottom: 10px; width: 100%;">
          {{ $audienceGroup['title'] ?? 'বইটি মূলত কাদের জন্য?' }}
        </h2>

        <ul style="list-style: none; padding: 0; margin: 0;">
          @foreach($audienceGroup['items'] ?? [] as $item)
            <li style="display: flex; align-items: flex-start; margin-bottom: 20px;">
              <span style="color: {{ $item['icon_color'] ?? 'var(--secondary-color)' }}; margin-right: 15px; flex-shrink: 0; font-size: 1.2rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"
                     fill="currentColor">
                  <path
                        d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" />
                </svg>
              </span>
              <span class="bengali-text" style="color: var(--dark-text); line-height: 1.6; font-size: 1.05rem;">
                @if(isset($item['text']))
                  @php
                    $textParts = explode(':', $item['text'], 2);
                    $boldPart = $textParts[0] ?? '';
                    $descriptionPart = $textParts[1] ?? '';
                  @endphp
                  @if($descriptionPart)
                    {{ $boldPart }}: {{ $descriptionPart }}
                  @else
                    {{ $item['text'] }}
                  @endif
                @endif
              </span>
            </li>
          @endforeach
        </ul>

        <div style="text-align: center; margin-top: 40px;">
          <button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
                  style="background-color: #1A237E; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                  onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            অর্ডার করুন
          </button>
        </div>
      </div>
      @endforeach
      @endif --}}

      <!-- Why a Game Changer Column (Full Width below) -->
      @if(!empty($gameChangerPoints))
      <div class="game-changer-section"
           style="grid-column: 1 / -1; margin-top: 50px; padding-top: 50px;">
        <h2 class="bengali-text feature-heading"
            style="color: white; margin: 0 0 30px; font-size: 1.8rem; font-weight: 700; padding-bottom: 10px; width: 100%; text-align: center; position: relative;">
          {{ $gameChangerTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <ul
            style="list-style: none; padding: 30px; margin: 0; background-color: white; border-radius: 10px; border: 2px solid var(--accent-color);">
          @if($gameChangerConclusion)
          <li class="bengali-text"
              style="font-size: 1.1rem; line-height: 1.8; color: var(--dark-text); margin-bottom: 15px;">
            "Spoken English in Real Life" আপনাকে ঠিক সেই জিনিসগুলো দেয়, যেগুলো ইংরেজিতে সফল হতে প্রয়োজন:
          </li>
          @endif
          @foreach($gameChangerPoints as $point)
            <li class="bengali-text"
                style="font-size: 1.1rem; line-height: 1.6; color: var(--dark-text); margin-bottom: 10px; display: flex;">
              <span style="color: var(--primary-color); margin-right: 10px;">✔</span> {{ $point }}
            </li>
          @endforeach

          @if($gameChangerConclusion)
          <li class="bengali-text"
              style="font-size: 1.1rem; line-height: 1.8; color: var(--dark-text); font-weight: 600; margin-top: 15px;">
            {{ $gameChangerConclusion }}
          </li>
          @endif
        </ul>

        <div style="text-align: center; margin-top: 30px;">
          <button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
                  style="background-color: #1A237E; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
                  onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            অর্ডার করুন
          </button>
        </div>
      </div>
      @endif

    </div>
  </div>
</section>

<style>
  .features-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 40px;
    align-items: start;
  }

  .feature-column {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .feature-heading {
    display: block;
    width: 100%;
  }

  .game-changer-section {
    grid-column: 1 / -1;
    margin-top: 50px;
    padding-top: 50px;
    /* border-top: 2px solid #e0e0e0; */
    width: 100%;
  }

  /* Tablet and larger devices - 2 columns */
  @media (min-width: 768px) {
    .features-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 40px;
    }
  }

  /* Medium devices - adjust spacing */
  @media (max-width: 968px) and (min-width: 768px) {
    .features-grid {
      gap: 30px;
    }

    .game-changer-section {
      margin-top: 40px;
      padding-top: 40px;
    }
  }

  /* Small devices - single column, full width */
  @media (max-width: 767px) {
    .features-section h2 {
      font-size: 1.5rem !important;
    }

    .features-grid {
      grid-template-columns: 1fr;
      gap: 30px;
    }

    .feature-column {
      width: 100%;
    }

    .game-changer-section {
      margin-top: 30px;
      padding-top: 30px;
      width: 100%;
    }
  }
</style>
