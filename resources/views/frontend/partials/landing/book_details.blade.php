@php
  // Get dynamic data from landing page
  $title = $landingPage->book_details_title ?? 'বইটি সম্পর্কে যা না জানলেই নয়';
  $description = $landingPage->book_details_description ?? '';
  $specialtiesTitle = $landingPage->book_details_specialties_title ?? ($landingPage->product_type === 'book' ? 'এই বইয়ের বিশেষত্ব:' : 'এই কোর্সের বিশেষত্ব:');
  $specialtiesDescription = $landingPage->book_details_specialties_description ?? '';
  $studentsLoveTitle = $landingPage->book_details_students_love_title ?? 'কেন শিক্ষার্থীরা এই বইকে ভালোবাসেন';
  $studentsLoveDescription = $landingPage->book_details_students_love_description ?? '';
  $extraordinaryTitle = $landingPage->book_details_extraordinary_title ?? 'কী এই বইটিকে সত্যিই অসাধারণ করে তুলেছে?';
  $extraordinaryDescription = $landingPage->book_details_extraordinary_description ?? '';

  // Default static content if empty
  $defaultDescription = '<span style="color: var(--primary-color); font-weight: 700;">SPOKEN ENGLISH IN REAL LIFE</span> হলো এমন একটি বই যা আপনাকে ইংরেজিতে কথা বলার ভয় দূর করে বাস্তব জীবনের যেকোনো পরিস্থিতিতে আত্মবিশ্বাসের সাথে ইংরেজিতে কথা বলতে সাহায্য করবে।
        <br><br>
        পুরো বইটি বাংলায় ব্যাখ্যা করা, যাতে যেকোনো শিক্ষার্থী খুব সহজেই বুঝে নিতে পারে এবং অনুশীলন করতে পারে।
        <br><br>
        এই বইয়ে আপনি যা পাবেন তা আপনাকে ধাপে ধাপে একজন আত্মবিশ্বাসী ইংরেজি বক্তায় পরিণত করবে—সম্পূর্ণ বাস্তব ব্যবহারভিত্তিক কনটেন্টে সাজানো।';


  // Use defaults if empty
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
      <!-- Full Width Sections: Extraordinary & Students Love -->
      <div style="margin-top: 60px;">

        <!-- Section 1: What makes it extraordinary -->
        @if (!empty($extraordinaryDescription))
          <div style="margin-bottom: 60px;">
            <h2 class="bengali-text"
                style="color: white; margin: 0 0 25px; font-size: 1.8rem; font-weight: 700; text-align: center; width: 100%; padding-bottom: 10px; position: relative;">
              {{ $extraordinaryTitle }}
              <span style="display: block; width: 20%; height: 2px; background: var(--accent-color); margin: 10px auto 0;"></span>
            </h2>
            
            <div style="background: white; padding: 25px; border-radius: 8px; border: 2px solid var(--accent-color);">
              <div class="bengali-text" style="color: var(--dark-text); line-height: 1.8; font-size: 1.05rem;">
                {!! $extraordinaryDescription !!}
              </div>
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
              <x-cta-button :landingPage="$landingPage" style="padding: 10px 25px; font-size: 0.9rem;" />
            </div>
          </div>
        @endif

        <!-- Section 2: Why Students Love -->
        @if (!empty($studentsLoveDescription))
          <div>
            <h2 class="bengali-text"
                style="color: white; margin: 0 0 25px; font-size: 1.8rem; font-weight: 700; text-align: center; width: 100%; padding-bottom: 10px; position: relative;">
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

    }
  </style>
</section>
