<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Landing Page - {{ config('app.name', 'Darpon') }}</title>

  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <!-- Scripts -->
  @vite(['resources/css/app.css'])
  <script src="{{ asset('js/alpine.min.js') }}" defer></script>

  @include('frontend.partials.landing.styles')
</head>

<body>
  <!-- Success/Error Messages -->
  @if (session('order_success'))
    <div
         style="position: fixed; top: 20px; right: 20px; background: #4caf50; color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; max-width: 400px;">
      <div style="font-weight: 700; font-size: 1.1rem; margin-bottom: 10px;">✓ Order Placed Successfully!</div>
      <div style="font-size: 0.9rem; margin-bottom: 10px;">Your order ID: <strong>#{{ session('order_id') }}</strong>
      </div>
      @if (session('is_new_user'))
        <div style="font-size: 0.85rem; background: rgba(255,255,255,0.2); padding: 8px; border-radius: 4px;">
          A password has been sent to your email. Please check your inbox.
        </div>
      @endif
      <button onclick="this.parentElement.style.display='none'"
              style="margin-top: 10px; background: rgba(255,255,255,0.3); border: none; color: white; padding: 5px 15px; border-radius: 4px; cursor: pointer;">Close</button>
    </div>
  @endif

  @if (session('error'))
    <div
         style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; max-width: 400px;">
      <div style="font-weight: 700; font-size: 1.1rem; margin-bottom: 10px;">✗ Error</div>
      <div style="font-size: 0.9rem;">{{ session('error') }}</div>
      <button onclick="this.parentElement.style.display='none'"
              style="margin-top: 10px; background: rgba(255,255,255,0.3); border: none; color: white; padding: 5px 15px; border-radius: 4px; cursor: pointer;">Close</button>
    </div>
  @endif

  <!-- Header Section -->
  @include('frontend.partials.landing.header')

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
    @include('frontend.partials.landing.faq')
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
