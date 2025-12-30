@php
  $heroEnglishTitle = $landingPage->hero_english_title ?? ($landingPage->book->title ?? 'BOOK TITLE');
  $heroBengaliTitle = $landingPage->hero_bengali_title ?? 'বইটির বর্ণনা এখানে লিখুন';
  $heroMainImage = $landingPage->hero_main_image ? Storage::url($landingPage->hero_main_image) : ($landingPage->book->cover_image ?? asset('darponbdv.png'));
  $previewImages = $landingPage->hero_preview_images ?? [];
@endphp

<section class="hero-section section-sm" style="background-color: #fff1d0; text-align: center;">
  <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
    
    <!-- Hero Image -->
    @if($heroMainImage)
      <div style="margin-bottom: 20px;">
        <img decoding="async" src="{{ $heroMainImage }}" 
             alt="{{ $heroEnglishTitle }}" 
             style="max-width: 100%; height: auto; width: 300px; display: block;">
      </div>
    @endif

    <!-- English Heading -->
    @if($heroEnglishTitle)
      <div style="margin-bottom: 15px;">
        <h2 style="margin: 0; color: #000000; font-family: 'Times New Roman', serif; font-weight: 700; font-size: 2rem; text-transform: uppercase;">
          {{ strtoupper($heroEnglishTitle) }}
        </h2>
      </div>
    @endif

    <!-- Bengali Heading -->
    @if($heroBengaliTitle)
      <div>
        <h2 class="bengali-text" style="margin: 0; color: #0d47a1; font-weight: 600; font-size: 1.5rem; line-height: 1.4;">
          {!! nl2br(e($heroBengaliTitle)) !!}
        </h2>
      </div>
    @endif

    <!-- Book Preview Carousel -->
    @if(count($previewImages) > 0)
      <div style="margin-top: 40px; width: 100%; overflow: hidden;">
        <div style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; justify-content: center;">
          @foreach($previewImages as $previewImage)
            <img src="{{ Storage::url($previewImage) }}" 
                 style="height: 200px; width: auto; border: 2px solid #ddd; border-radius: 5px;" 
                 alt="Page Preview {{ $loop->iteration }}">
          @endforeach
        </div>
      </div>
    @endif

  </div>
  <style>
    @media (max-width: 768px) {
      .hero-section h2 {
        font-size: 1.2rem !important;
      }
      .hero-section img {
        width: 200px !important;
      }
    }
  </style>
</section>
