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
    
    <div style="background: #ffffff; padding: 40px; border-radius: 15px; border: 2px solid var(--accent-color); box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
      
      <h2 class="bengali-text" style="color: var(--primary-color); font-size: 2rem; font-weight: 700; margin-bottom: 20px;">
        {{ $landingPage->pricing_book_label ?? ($landingPage->book ? 'Book Price:' : 'Course Fee:') }}
      </h2>

      <!-- Price Display -->
      <div style="margin-bottom: 30px;">
        
        <!-- Course Duration (if course) -->
        @if($courseDuration)
        <div style="margin-bottom: 15px;">
          <p class="bengali-text" style="font-size: 1.2rem; color: var(--primary-color); font-weight: 600;">
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
        
        <div style="font-size: 1.5rem; color: var(--dark-text); font-weight: 600; line-height: 1.8;">
          @if($originalPrice > $offerPrice)
            <span style="text-decoration: line-through; color: #777; margin-right: 20px;">
              {{ $regularLabel }}: Tk. {{ number_format($originalPrice, 0) }}
            </span>
          @endif
          <span style="color: var(--accent-color); font-weight: 700;">
            {{ $offerLabel }}: Tk. {{ number_format($offerPrice, 0) }}
          </span>
        </div>

      </div>

      <!-- Description and Note -->
      <div style="margin-bottom: 30px;">
        @if($pricingDescription)
        <p class="bengali-text" style="font-size: 1.1rem; line-height: 1.6; color: var(--dark-text); margin-bottom: 15px;">
          {!! nl2br(e($pricingDescription)) !!}
        </p>
        @endif
        @if($pricingNote)
        <h3 class="bengali-text" style="color: #d32f2f; font-size: 1.3rem; font-weight: 700;">
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
    .pricing-section h2 {
      font-size: 1.6rem !important;
    }
    .pricing-section h3[style*="font-size: 2.5rem"] {
      font-size: 2rem !important;
    }
    .pricing-section button {
      width: 100%;
      padding: 12px 20px !important;
      font-size: 1.1rem !important;
    }
  }
</style>
