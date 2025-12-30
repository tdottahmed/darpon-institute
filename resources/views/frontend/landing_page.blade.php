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
  <!-- Header Section -->
  @include('frontend.partials.landing.header')

  <!-- Main Banner Section -->
  @if ($landingPage->show_hero ?? true)
    @include('frontend.partials.landing.hero', ['landingPage' => $landingPage])
  @endif

  <!-- PDF Preview Section -->
  @if ($landingPage->show_pdf_preview ?? true)
    @include('frontend.partials.landing.pdf_preview', ['landingPage' => $landingPage])
  @endif

  <!-- Author Section -->
  @include('frontend.partials.landing.author')

  <!-- Book Details Section -->
  @if ($landingPage->show_book_details ?? true)
    @include('frontend.partials.landing.book_details', ['landingPage' => $landingPage])
  @endif

  <!-- Features Section -->
  @if ($landingPage->show_features ?? true)
    @include('frontend.partials.landing.features', ['landingPage' => $landingPage])
  @endif

  <!-- FAQ Section -->
  @include('frontend.partials.landing.faq')

  <!-- Pricing Section -->
  @if ($landingPage->show_pricing ?? true)
    @include('frontend.partials.landing.pricing', ['landingPage' => $landingPage])
  @endif

  <!-- Order Section -->
  @if ($landingPage->show_order ?? true)
    @include('frontend.partials.landing.order', ['landingPage' => $landingPage])
  @endif

  <!-- Footer -->
  @include('frontend.partials.landing.footer')

  <!-- Scripts -->
  @include('frontend.partials.landing.scripts')
</body>

</html>
