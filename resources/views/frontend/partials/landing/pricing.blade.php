@php
  // Get prices from landing page or fallback to book
  $originalPrice = $landingPage->pricing_original_price ?? ($landingPage->book->price ?? 0);
  $offerPrice = $landingPage->pricing_offer_price ?? ($landingPage->book->discounted_price ?? $originalPrice);
  $pricingDescription = $landingPage->pricing_description ?? '';
  $pricingNote = $landingPage->pricing_note ?? '';
@endphp

<section class="pricing-section section" style="background-color: #353e4b;">
  <div class="container-narrow" style="text-align: center;">
    
    <div style="background: #ffffff; padding: 40px; border-radius: 15px; border: 2px solid var(--accent-color); box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
      
      <h2 class="bengali-text" style="color: var(--primary-color); font-size: 2rem; font-weight: 700; margin-bottom: 20px;">
        {{ $landingPage->book ? 'বইয়ের মূল্য:' : 'কোর্সের মূল্য:' }}
      </h2>

      <!-- Price Display -->
      <div style="margin-bottom: 30px;">
        
        <!-- Original Price -->
        @if($originalPrice > $offerPrice)
        <h3 class="bengali-text" style="font-size: 1.5rem; color: #555; margin-bottom: 10px;">
          প্রকৃত মূল্য: 
          <span style="position: relative; display: inline-block; color: #777;">
            {{ number_format($originalPrice, 0) }} টাকা
            <svg style="position: absolute; top: 50%; left: -5%; width: 110%; height: 2px; overflow: visible;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
              <path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4" stroke="red" stroke-width="25" fill="none" opacity="0.6"/>
              <path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7" stroke="red" stroke-width="25" fill="none" opacity="0.6"/>
            </svg>
          </span>
        </h3>
        @endif

        <!-- Offer Price -->
        <h3 class="bengali-text" style="font-size: 2.5rem; color: var(--accent-color); font-weight: 800; margin: 10px 0;">
          অফার মূল্য <span style="position: relative; display: inline-block;">
             {{ number_format($offerPrice, 0) }} টাকা
             <svg style="position: absolute; bottom: -10px; left: 0; width: 100%; height: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
               <path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6" stroke="var(--accent-color)" stroke-width="15" fill="none"/>
             </svg>
          </span>
        </h3>

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
      <button onclick="document.getElementById('orderFormSection').scrollIntoView({behavior: 'smooth'})" style="background-color: #1A237E; color: var(--light-text); border: none; border-radius: 5px; padding: 15px 30px; font-size: 1.2rem; font-weight: 700; cursor: pointer; transition: background-color 0.3s; text-transform: uppercase;" onmouseover="this.style.backgroundColor='#f57c00'" onmouseout="this.style.backgroundColor='#1A237E'">
        {{ $landingPage->product_type === 'course' ? 'রেজিস্ট্রেশন করুন' : 'অর্ডার করুন' }}
      </button>

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
