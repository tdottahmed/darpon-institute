@php
  // Get prices from landing page or fallback to book
  $originalPrice = $landingPage->pricing_original_price ?? ($landingPage->book->price ?? 0);
  $offerPrice = $landingPage->pricing_offer_price ?? ($landingPage->book->discounted_price ?? $originalPrice);
  $pricingDescription = $landingPage->pricing_description ?? '';
  $pricingNote = $landingPage->pricing_note ?? '';
  
  // Get course duration if product type is course
  $courseDuration = null;
  if ($landingPage->product_type === 'course' && $landingPage->course) {
    $courseDuration = $landingPage->course->duration ?? null;
  }
@endphp

<section class="pricing-section section" style="background-color: #073050;">
  <div class="container-narrow" style="text-align: center;">
    
    <div class="pricing-card" style="background: #ffffff; padding: 40px; border-radius: 15px; border: 2px solid var(--accent-color); box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
      
      <h2 class="bengali-text pricing-title" style="color: var(--primary-color); font-size: 2rem; font-weight: 700; margin-bottom: 20px;">
        {{ $landingPage->pricing_book_label ?? ($landingPage->book ? 'Book Price:' : 'Course Fee:') }}
      </h2>

      <!-- Price Display -->
      <div style="margin-bottom: 30px;">
        
        <!-- Course Duration (if course) -->
        @if($courseDuration)
        <div class="pricing-duration-wrapper" style="margin-bottom: 15px;">
          <p class="bengali-text pricing-duration" style="font-size: 1.2rem; color: var(--primary-color); font-weight: 600;">
            Course Duration: <span style="color: var(--dark-text);">{{ $courseDuration }}</span>
          </p>
        </div>
        @endif
        
        <!-- Price Display -->
        @php
          $isCourse = $landingPage->product_type === 'course';
          $regularLabel = $landingPage->pricing_regular_label ?? ($isCourse ? 'Regular Fee' : 'Regular Price');
          $offerLabel = $landingPage->pricing_offer_label ?? ($isCourse ? 'Offer Fee' : 'Offer Price');
        @endphp
        
        <div class="price-display-wrapper" style="font-size: 1.5rem; color: var(--dark-text); font-weight: 600; line-height: 1.8;">
          @if($originalPrice > $offerPrice)
            <span class="regular-price" style="text-decoration: line-through; color: #777; margin-right: 20px;">
              {{ $regularLabel }}: Tk. {{ number_format($originalPrice, 0) }}
            </span>
          @endif
          <span class="offer-price" style="color: var(--accent-color); font-weight: 700;">
            {{ $offerLabel }}: Tk. {{ number_format($offerPrice, 0) }}
          </span>
        </div>

      </div>

      <!-- Description and Note -->
      <div style="margin-bottom: 30px;">
        @if($pricingDescription)
        <p class="bengali-text pricing-description" style="font-size: 1.1rem; line-height: 1.6; color: var(--dark-text); margin-bottom: 15px;">
          {!! nl2br(e($pricingDescription)) !!}
        </p>
        @endif
        @if($pricingNote)
        <h3 class="bengali-text pricing-note" style="color: #d32f2f; font-size: 1.3rem; font-weight: 700;">
          {!! nl2br(e($pricingNote)) !!}
        </h3>
        @endif
      </div>

      <!-- Order Button -->
      <x-cta-button :landingPage="$landingPage" style="color: var(--light-text); padding: 15px 30px; font-size: 1.2rem; font-weight: 700; text-transform: uppercase;" />

    </div>
  </div>
</section>

<style>
  @media (max-width: 768px) {
    .pricing-section h2.pricing-title {
      font-size: 2rem !important;
    }
    .pricing-card {
      padding: 20px !important;
    }
    .pricing-duration {
      font-size: 1rem !important;
    }
    .price-display-wrapper {
      font-size: 1.2rem !important;
      line-height: 1.5 !important;
    }
    .price-display-wrapper .regular-price {
      margin-right: 0 !important;
      display: block;
      margin-bottom: 5px;
    }
    .price-display-wrapper .offer-price {
      font-size: 1.2rem !important;
    }
    .pricing-description {
      font-size: 1rem !important;
    }
    .pricing-note {
      font-size: 1.1rem !important;
    }
    .pricing-section button {
      width: 100%;
      padding: 12px 20px !important;
      font-size: 1rem !important;
    }
  }
</style>
