<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if($landingPage->meta_description ?? null)
    <meta name="description" content="{{ $landingPage->meta_description }}">
  @endif

  <title>{{ $landingPage->meta_title ?? ($landingPage->book->title ?? $landingPage->course->title ?? config('app.name', 'Darpon')) }}</title>

  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <!-- SEO: Sitemap & RSS Feed -->
  @php
    $sitemapUrl = \App\Models\Setting::get('sitemap_url');
    $rssFeedUrl = \App\Models\Setting::get('rss_feed_url');
  @endphp
  @if($sitemapUrl)
    <link rel="sitemap" type="application/xml" href="{{ $sitemapUrl }}">
  @endif
  @if($rssFeedUrl)
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="{{ $rssFeedUrl }}">
  @endif

  <!-- Scripts -->
  @vite(['resources/css/app.css'])
  <script src="{{ asset('js/alpine.min.js') }}" defer></script>

  @if ($landingPage->slug === 'darpon-english-teaching-zone')
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">
  @endif

  @include('frontend.partials.landing.styles')

  @if ($landingPage->slug === 'darpon-english-teaching-zone')
    <style>
      .bengali-text {
        font-family: 'Noto Sans Bengali', 'SutonnyMJ', 'SolaimanLipi', 'Kalpurush', sans-serif;
      }
    </style>
  @endif

  <!-- Google Analytics -->
  <x-google-analytics />

  <!-- Facebook Pixel -->
  <x-facebook-pixel />
</head>

<body>
  {{-- Success modal — covers both book orders (order_success) and course enrollments (registration_success) --}}
  @php
    $isEnrollment    = (bool) session('registration_success');
    $isOrderSuccess  = (bool) session('order_success');
    $successId       = session('order_id') ?? session('registration_id');
    $newUser         = (bool) session('is_new_user');
  @endphp

  @if ($isOrderSuccess || $isEnrollment)
    <div id="successOverlay"
         style="position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 20px;"
         role="dialog" aria-modal="true" aria-labelledby="successModalTitle">
      <div style="background: #fff; border-radius: 12px; padding: 40px 30px; max-width: 460px; width: 100%; text-align: center; box-shadow: 0 24px 64px rgba(0,0,0,0.35);">

        {{-- Icon --}}
        <div style="width: 72px; height: 72px; background: #4caf50; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
          <svg width="36" height="36" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
        </div>

        {{-- Title --}}
        <h2 id="successModalTitle" style="font-size: 1.4rem; font-weight: 700; color: #1a1a1a; margin: 0 0 10px;">
          {{ $isEnrollment ? 'Enrollment Successful!' : 'Order Placed Successfully!' }}
        </h2>

        {{-- ID --}}
        @if ($successId)
          <p style="color: #555; font-size: 0.95rem; margin: 0 0 6px;">
            {{ $isEnrollment ? 'Registration ID' : 'Order ID' }}:
            <strong style="color: #1a1a1a; font-family: monospace;">#{{ $successId }}</strong>
          </p>
        @endif

        {{-- New user notice --}}
        @if ($newUser)
          <div style="background: #e8f5e9; border-radius: 6px; padding: 12px 16px; margin: 16px 0; font-size: 0.875rem; color: #2e7d32; text-align: left; line-height: 1.5;">
            ✓ A new account has been created for you. Your login password has been sent to your email — please check your inbox.
          </div>
        @endif

        {{-- Body copy --}}
        <p style="color: #777; font-size: 0.875rem; margin: 14px 0 28px; line-height: 1.6;">
          @if ($isEnrollment)
            Your enrollment has been received. We will verify your details and get back to you shortly.
          @else
            We will contact you soon to arrange delivery. Thank you for your order!
          @endif
        </p>

        <button id="successOverlayClose"
                style="background: #4caf50; color: white; border: none; padding: 13px 36px; border-radius: 6px; font-size: 1rem; font-weight: 600; cursor: pointer; width: 100%;">
          OK, Got it!
        </button>
      </div>
    </div>
    <script>
      (function () {
        var overlay  = document.getElementById('successOverlay');
        var closeBtn = document.getElementById('successOverlayClose');
        function close() { overlay.style.display = 'none'; }
        closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
        setTimeout(close, 20000);
      })();
    </script>
  @endif

  {{-- Error modal --}}
  @if (session('error'))
    <div id="errorOverlay"
         style="position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 20px;"
         role="alertdialog" aria-modal="true" aria-labelledby="errorModalTitle">
      <div style="background: #fff; border-radius: 12px; padding: 36px 30px; max-width: 440px; width: 100%; text-align: center; box-shadow: 0 24px 64px rgba(0,0,0,0.35);">
        <div style="width: 64px; height: 64px; background: #f44336; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px;">
          <svg width="30" height="30" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </div>
        <h2 id="errorModalTitle" style="font-size: 1.25rem; font-weight: 700; color: #1a1a1a; margin: 0 0 10px;">
          Something went wrong
        </h2>
        <p style="color: #555; font-size: 0.9rem; line-height: 1.6; margin: 0 0 24px;">
          {{ session('error') }}
        </p>
        <button id="errorOverlayClose"
                style="background: #f44336; color: white; border: none; padding: 12px 32px; border-radius: 6px; font-size: 0.95rem; font-weight: 600; cursor: pointer; width: 100%;">
          Try Again
        </button>
      </div>
    </div>
    <script>
      (function () {
        var overlay  = document.getElementById('errorOverlay');
        var closeBtn = document.getElementById('errorOverlayClose');
        function close() { overlay.style.display = 'none'; }
        closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
      })();
    </script>
  @endif

  {{-- Scroll to the first validation error so the user doesn't miss it --}}
  @if ($errors->any())
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        var firstError = document.querySelector('[style*="color: red"]');
        if (firstError) {
          firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
          var form = document.getElementById('orderFormSection');
          if (form) form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    </script>
  @endif

  <!-- Header Section -->
  @include('frontend.partials.landing.header', ['landingPage' => $landingPage])

  <!-- Main Banner Section -->
  @if ($landingPage->show_hero ?? true)
    @include('frontend.partials.landing.hero', ['landingPage' => $landingPage])
  @endif

  <!-- PDF Preview Section -->
  @if ($landingPage->show_pdf_preview ?? true && $landingPage->product_type === 'book')
    @include('frontend.partials.landing.pdf_preview', ['landingPage' => $landingPage])
  @endif

  <!-- Author Section -->
  @include('frontend.partials.landing.author', ['landingPage' => $landingPage])

  <!-- Book Details Section -->
  @if ($landingPage->show_book_details ?? true)
    @include('frontend.partials.landing.book_details', ['landingPage' => $landingPage])
  @endif

  <!-- Features Section -->
  @if ($landingPage->show_features ?? true)
    @include('frontend.partials.landing.features', ['landingPage' => $landingPage])
  @endif

  <!-- FAQ Section -->
  @if ($landingPage->product_type === 'book')
    @include('frontend.partials.landing.faq', ['landingPage' => $landingPage])
  @endif

  <!-- Pricing Section -->
  @if ($landingPage->show_pricing ?? true)
    @include('frontend.partials.landing.pricing', ['landingPage' => $landingPage])
  @endif

  <!-- Order Section -->
  @if ($landingPage->show_order)
    @include('frontend.partials.landing.order')
  @endif

  <!-- Footer -->
  @include('frontend.partials.landing.footer')

  <!-- Scripts -->
  @include('frontend.partials.landing.scripts')
</body>

</html>
