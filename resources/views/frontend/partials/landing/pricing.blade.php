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

<section class="pricing-section" style="background-color: #073050; padding-top: 20px">
    <div class="container-narrow pricing-container">

        <div class="pricing-card" style="padding-bottom: 10px;">

            <h2 class="bengali-text pricing-title">
                {{ $landingPage->pricing_book_label ?? ($landingPage->book ? 'Book Price' : 'Course Fee') }}
            </h2>
            <span class="pricing-divider"></span>

            <!-- Price Display -->
            <div class="pricing-content-wrapper">

                <!-- Course Duration (if course) -->
                @if ($courseDuration)
                    <div class="pricing-duration-wrapper">
                        <p class="bengali-text pricing-duration">
                            Course Duration: <span class="pricing-duration-value">{{ $courseDuration }}</span>
                        </p>
                    </div>
                @endif

                <!-- Price Display -->
                @php
                    $isCourse = $landingPage->product_type === 'course';
                    $regularLabel =
                        $landingPage->pricing_regular_label ?? ($isCourse ? 'Regular Fee' : 'Regular Price');
                    $offerLabel = $landingPage->pricing_offer_label ?? ($isCourse ? 'Offer Fee' : 'Offer Price');
                @endphp

                <div class="price-display-wrapper">
                    @if ($originalPrice > $offerPrice)
                        <span class="regular-price">
                            {{ $regularLabel }}: Tk. {{ number_format($originalPrice, 0) }}
                        </span>
                    @endif
                    <span class="offer-price">
                        {{ $offerLabel }}: Tk. {{ number_format($offerPrice, 0) }}
                    </span>
                </div>

            </div>

            <!-- Description and Note -->
            <div class="pricing-info-wrapper">
                @if ($pricingDescription)
                    <p class="bengali-text pricing-description">
                        {!! nl2br(e($pricingDescription)) !!}
                    </p>
                @endif
                @if ($pricingNote)
                    <h3 class="bengali-text pricing-note">
                        {!! nl2br(e($pricingNote)) !!}
                    </h3>
                @endif
            </div>

            <!-- Order Button -->
            <div class="pricing-cta-wrapper">
                <x-cta-button :landingPage="$landingPage" />
            </div>

        </div>
    </div>
</section>

<style>
    .pricing-container {
        text-align: center;
    }

    .pricing-card {
        background: #ffffff;
        padding: 40px;
        border-radius: 15px;
        border: 2px solid var(--accent-color);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .pricing-title {
        color: var(--primary-color);
        font-size: 1.8rem;
        font-weight: 700;
        text-align: left;
    }

    .pricing-divider {
        display: block;
        width: 30%;
        height: 2px;
        background: var(--accent-color);
        margin: 10px 0 0;
    }

    .pricing-content-wrapper {
        margin-bottom: 30px;
        margin-top: 20px;
        text-align: left;
    }

    .pricing-duration-wrapper {
        margin-bottom: 15px;
    }

    .pricing-duration {
        font-size: 1.2rem;
        color: var(--primary-color);
        font-weight: 600;
    }

    .pricing-duration-value {
        color: var(--dark-text);
    }

    .price-display-wrapper {
        font-size: 1.5rem;
        color: var(--dark-text);
        font-weight: 600;
        line-height: 1.8;
        text-align: left;
    }

    .regular-price {
        text-decoration: line-through;
        color: #777;
        margin-right: 20px;
    }

    .offer-price {
        color: var(--accent-color);
        font-weight: 700;
    }

    .pricing-info-wrapper {
        margin-bottom: 30px;
    }

    .pricing-description {
        font-size: 1.1rem;
        text-align: left !important;
        line-height: 1.6;
        color: var(--dark-text);
        margin-bottom: 15px;
    }

    .pricing-note {
        color: #d32f2f;
        font-size: 1.3rem;
        font-weight: 700;
        text-align: left !important;
    }

    .pricing-cta-wrapper {
        color: var(--light-text);
    }

    .pricing-cta-wrapper button,
    .pricing-cta-wrapper a {
        padding: 15px 30px;
        font-size: 1.2rem;
        font-weight: 700;
        text-transform: uppercase;
    }

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
            text-align: left !important;
        }

        .price-display-wrapper .regular-price {
            margin-right: 0 !important;
            display: block;
            margin-bottom: 5px;
            text-align: left !important;
        }

        .price-display-wrapper .offer-price {
            font-size: 1.2rem !important;
            text-align: left !important;
            display: block;
        }

        .pricing-description {
            font-size: 1rem !important;
        }

        .pricing-note {
            font-size: 1.1rem !important;
        }

        .pricing-cta-wrapper button,
        .pricing-cta-wrapper a {
            width: 100%;
            padding: 12px 20px !important;
            font-size: 1rem !important;
        }
    }
</style>
