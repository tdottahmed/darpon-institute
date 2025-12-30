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
  @include('frontend.partials.landing.hero')

  <!-- PDF Preview Section -->
  @include('frontend.partials.landing.pdf_preview')

  <!-- Author Section -->
  @include('frontend.partials.landing.author')

  <!-- Book Details Section -->
  @include('frontend.partials.landing.book_details')

  <!-- Features Section -->
  @include('frontend.partials.landing.features')

  <!-- FAQ Section -->
  @include('frontend.partials.landing.faq')

  <!-- Pricing Section -->
  @include('frontend.partials.landing.pricing')

  <!-- Order Section -->
  @include('frontend.partials.landing.order')

  <!-- Footer -->
  @include('frontend.partials.landing.footer')

  <!-- Scripts -->
  @include('frontend.partials.landing.scripts')
</body>

</html>
