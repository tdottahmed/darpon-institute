@php
  // Get dynamic data from landing page
  $title = $landingPage->book_details_title ?? 'বইটি সম্পর্কে যা না জানলেই নয়';
  $description = $landingPage->book_details_description ?? '';

  // Get specialties
  $specialties = [];
  if ($landingPage->book_details_specialties) {
      $specialties = is_array($landingPage->book_details_specialties)
          ? $landingPage->book_details_specialties
          : json_decode($landingPage->book_details_specialties, true) ?? [];
  }

  // Get extraordinary points
  $extraordinary = [];
  if ($landingPage->book_details_extraordinary) {
      $extraordinary = is_array($landingPage->book_details_extraordinary)
          ? $landingPage->book_details_extraordinary
          : json_decode($landingPage->book_details_extraordinary, true) ?? [];
  }

  // Get students love points
  $studentsLove = [];
  if ($landingPage->book_details_students_love) {
      $studentsLove = is_array($landingPage->book_details_students_love)
          ? $landingPage->book_details_students_love
          : json_decode($landingPage->book_details_students_love, true) ?? [];
  }

  // Default static content if empty
  $defaultDescription = '<span style="color: var(--primary-color); font-weight: 700;">SPOKEN ENGLISH IN REAL LIFE</span> হলো এমন একটি বই যা আপনাকে ইংরেজিতে কথা বলার ভয় দূর করে বাস্তব জীবনের যেকোনো পরিস্থিতিতে আত্মবিশ্বাসের সাথে ইংরেজিতে কথা বলতে সাহায্য করবে।
        <br><br>
        পুরো বইটি বাংলায় ব্যাখ্যা করা, যাতে যেকোনো শিক্ষার্থী খুব সহজেই বুঝে নিতে পারে এবং অনুশীলন করতে পারে।
        <br><br>
        এই বইয়ে আপনি যা পাবেন তা আপনাকে ধাপে ধাপে একজন আত্মবিশ্বাসী ইংরেজি বক্তায় পরিণত করবে—সম্পূর্ণ বাস্তব ব্যবহারভিত্তিক কনটেন্টে সাজানো।';

  $defaultSpecialties = [
      [
          'title' => '১০৮ টি লেসন—Beginner থেকে Advanced পর্যন্ত',
          'description' =>
              'প্রতিটি লেসন বাস্তব জীবনের নির্দিষ্ট পরিস্থিতির উপর সাজানো—যেমন দোকান, বাজার, ভ্রমণ, স্কুল, অফিস, ফোনকল, রেস্টুরেন্ট, হোটেল, চিকিৎসা, অ্যাপয়েন্টমেন্ট, ইত্যাদি।',
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
  if (empty($description)) {
      $description = $defaultDescription;
  }
@endphp

<section class="book-details-section section" style="background-color: #f0f4f8;">
  <div class="container-narrow">

    <!-- Main Heading -->
    <div style="text-align: center; margin-bottom: 40px;">
      <h2 class="bengali-text"
          style="color: var(--primary-color); font-size: 2rem; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">
        {{ $title }}
      </h2>
      <div style="width: 80px; height: 4px; background-color: var(--accent-color); margin: 0 auto;"></div>
    </div>

    <!-- Description Block -->
    @if ($description)
      <div
           style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 40px; text-align: left;">
        <h3 class="bengali-text" style="color: #444; font-size: 1.2rem; line-height: 1.8; font-weight: 500;">
          {!! $description !!}
        </h3>
      </div>
    @endif

    <!-- Specialties List -->
    @if (!empty($specialties))
      <div>
        <h2 class="bengali-text"
            style="color: var(--primary-color); margin: 0 0 25px; font-size: 1.8rem; font-weight: 700; border-bottom: 2px solid var(--accent-color); display: inline-block; padding-bottom: 10px;">
          {{ $landingPage->product_type === 'book' ? 'এই বইয়ের বিশেষত্ব:' : 'এই কোর্সের বিশেষত্ব:' }}
        </h2>

        <ul style="list-style: none; padding: 0; margin: 0;">
          @foreach ($specialties as $specialty)
            <li
                style="display: flex; align-items: flex-start; margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
              <span
                    style="color: var(--primary-color); margin-right: 15px; flex-shrink: 0; font-size: 1.2rem; margin-top: 2px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"
                     fill="currentColor">
                  <path
                        d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z" />
                </svg>
              </span>
              <span class="bengali-text" style="color: var(--dark-text); line-height: 1.6; font-size: 1.05rem;">
                @if (isset($specialty['title']))
                  <b>{{ $specialty['title'] }}:</b>
                @endif
                @if (isset($specialty['description']))
                  {{ $specialty['description'] }}
                @elseif(is_string($specialty))
                  {{ $specialty }}
                @endif
              </span>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

    <div style="text-align: center; margin-top: 40px;">
      <button onclick="document.getElementById('orderForm').scrollIntoView({behavior: 'smooth'})"
              style="background-color: #1A237E; color: white; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s;"
              onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        অর্ডার করুন
      </button>
    </div>

    @if ($landingPage->product_type === 'book')
      <!-- New Two Column Section: Extraordinary & Students Love -->
      <div
           style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-top: 60px;">

        <!-- Column 1: What makes it extraordinary -->
        @if (!empty($extraordinary))
          <div>
            <h2 class="bengali-text"
                style="color: var(--primary-color); margin: 0 0 25px; font-size: 1.6rem; font-weight: 700; border-bottom: 2px solid var(--accent-color); display: inline-block; padding-bottom: 10px;">
              কী এই বইটিকে সত্যিই অসাধারণ করে তুলেছে?
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
              @foreach ($extraordinary as $point)
                <li
                    style="margin-bottom: 15px; background: white; padding: 12px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); border-left: 4px solid var(--accent-color);">
                  <span class="bengali-text" style="color: #444; font-size: 1.05rem;">{{ $point }}</span>
                </li>
              @endforeach
              <li style="margin-top: 20px;">
                <p class="bengali-text" style="color: var(--dark-text); line-height: 1.6; font-weight: 600;">বইটির
                  প্রতিটি পৃষ্ঠা আপনাকে নতুন কিছু শেখাবে, আত্মবিশ্বাস গড়ে তুলবে, এবং বাস্তব পরিস্থিতিতে ইংরেজি বলতে
                  সাহায্য করবে</p>
              </li>
            </ul>
            <div style="text-align: center; margin-top: 20px;">
              <button onclick="document.getElementById('orderForm').scrollIntoView({behavior: 'smooth'})"
                      style="background-color: #1A237E; color: white; border: none; padding: 10px 25px; border-radius: 5px; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                অর্ডার করুন
              </button>
            </div>
          </div>
        @endif

        <!-- Column 2: Why Students Love -->
        @if (!empty($studentsLove))
          <div>
            <h2 class="bengali-text"
                style="color: var(--primary-color); margin: 0 0 25px; font-size: 1.6rem; font-weight: 700; border-bottom: 2px solid var(--accent-color); display: inline-block; padding-bottom: 10px;">
              কেন শিক্ষার্থীরা এই বইকে ভালোবাসেন
            </h2>
            <ul style="list-style: none; padding: 0; margin: 0;">
              @foreach ($studentsLove as $point)
                <li
                    style="margin-bottom: 15px; background: white; padding: 12px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); border-left: 4px solid var(--primary-color);">
                  <span class="bengali-text"
                        style="color: #444; font-size: 1.05rem; line-height: 1.5; display: block;">{{ $point }}</span>
                </li>
              @endforeach
            </ul>
            <div style="text-align: center; margin-top: 20px;">
              <button onclick="document.getElementById('orderForm').scrollIntoView({behavior: 'smooth'})"
                      style="background-color: #1A237E; color: white; border: none; padding: 10px 25px; border-radius: 5px; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                অর্ডার করুন
              </button>
            </div>
          </div>
        @endif

      </div>
    @endif

  </div>
  </div>

  <style>
    @media (max-width: 768px) {
      .book-details-section h2 {
        font-size: 1.5rem !important;
      }

      .book-details-section .container-narrow>div[style*="grid-template-columns"] {
        gap: 20px !important;
      }
    }
  </style>
</section>
