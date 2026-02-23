@php
  // Get dynamic data from landing page
  $title = $landingPage->book_details_title ?? 'বইটি সম্পর্কে যা না জানলেই নয়';
  $description = $landingPage->book_details_description ?? '';
  $specialtiesTitle = $landingPage->book_details_specialties_title ?? ($landingPage->product_type === 'book' ? 'এই বইয়ের বিশেষত্ব:' : 'এই কোর্সের বিশেষত্ব:');
  $specialtiesDescription = $landingPage->book_details_specialties_description ?? '';
  $studentsLoveTitle = $landingPage->book_details_students_love_title ?? 'কেন শিক্ষার্থীরা এই বইকে ভালোবাসেন';
  $studentsLoveDescription = $landingPage->book_details_students_love_description ?? '';

  // Get extraordinary points (still used)
  $extraordinary = [];
  if ($landingPage->book_details_extraordinary) {
      $extraordinary = is_array($landingPage->book_details_extraordinary)
          ? $landingPage->book_details_extraordinary
          : json_decode($landingPage->book_details_extraordinary, true) ?? [];
  }

  // Default static content if empty
  $defaultDescription = '<span style="color: var(--primary-color); font-weight: 700;">SPOKEN ENGLISH IN REAL LIFE</span> হলো এমন একটি বই যা আপনাকে ইংরেজিতে কথা বলার ভয় দূর করে বাস্তব জীবনের যেকোনো পরিস্থিতিতে আত্মবিশ্বাসের সাথে ইংরেজিতে কথা বলতে সাহায্য করবে।
        <br><br>
        পুরো বইটি বাংলায় ব্যাখ্যা করা, যাতে যেকোনো শিক্ষার্থী খুব সহজেই বুঝে নিতে পারে এবং অনুশীলন করতে পারে।
        <br><br>
        এই বইয়ে আপনি যা পাবেন তা আপনাকে ধাপে ধাপে একজন আত্মবিশ্বাসী ইংরেজি বক্তায় পরিণত করবে—সম্পূর্ণ বাস্তব ব্যবহারভিত্তিক কনটেন্টে সাজানো।';

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
  if (empty($description)) {
      $description = $defaultDescription;
  }
@endphp

<section class="book-details-section section" style="background-color: #073050;">
  <div class="container-narrow">

    <!-- Main Heading -->
    <div style="text-align: center; margin-bottom: 40px;">
      <h2 class="bengali-text"
          style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">
        {{ $title }}
      </h2>
      <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
    </div>

    <!-- Description Block -->
    @if ($description)
      <div
           style="background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 40px; text-align: left; border: 2px solid var(--accent-color);">
        <h3 class="bengali-text" style="color: #444; font-size: 1.2rem; line-height: 1.8; font-weight: 500;">
          {!! $description !!}
        </h3>
      </div>
    @endif

    <!-- Specialties Description -->
    @if (!empty($specialtiesDescription))
      <div>
        <h2 class="bengali-text"
            style="color: white; margin: 0 0 25px; font-size: 1.8rem; text-align: center; font-weight: 700; padding-bottom: 10px; width: 100%; position: relative;">
          {{ $specialtiesTitle }}
          <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
        </h2>

        <div style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
          <div class="bengali-text" style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem;">
            {!! $specialtiesDescription !!}
          </div>
        </div>
      </div>
    @endif

    <div style="text-align: center; margin-top: 40px;">
      <x-cta-button :landingPage="$landingPage" />
    </div>

    @if ($landingPage->product_type === 'book')
      <!-- New Two Column Section: Extraordinary & Students Love -->
      <div
           style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-top: 60px;">

        <!-- Column 1: What makes it extraordinary -->
        {{-- @if (!empty($extraordinary))
          <div>
            <h2 class="bengali-text"
                style="color: var(--primary-color); margin: 0 0 25px; font-size: 1.6rem; font-weight: 700; text-align: center; width: 100%; border-bottom: 2px solid var(--accent-color); display: inline-block; padding-bottom: 10px;">
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
              <button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})"
                      style="background-color: #1A237E; color: white; border: none; padding: 10px 25px; border-radius: 5px; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                অর্ডার করুন
              </button>
            </div>
          </div>
        @endif --}}

        <!-- Column 2: Why Students Love -->
        @if (!empty($studentsLoveDescription))
          <div>
            <h2 class="bengali-text"
                style="color: white; margin: 0 0 25px; font-size: 1.6rem; font-weight: 700; text-align: center; width: 100%; padding-bottom: 10px; position: relative;">
              {{ $studentsLoveTitle }}
              <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
            </h2>
            <div style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
              <div class="bengali-text" style="color: #444; font-size: 1.05rem; line-height: 1.8;">
                {!! $studentsLoveDescription !!}
              </div>
            </div>
            <div style="text-align: center; margin-top: 20px;">
              <x-cta-button :landingPage="$landingPage" style="padding: 10px 25px; font-size: 0.9rem;" />
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
