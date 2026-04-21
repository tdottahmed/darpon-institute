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

  @vite(['resources/css/app.css'])
  <script src="{{ asset('js/alpine.min.js') }}" defer></script>

  <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  @include('frontend.partials.landing.styles')

  <style>
    .bengali-text {
      font-family: 'Noto Sans Bengali', 'Hind Siliguri', 'Inter', 'Segoe UI', Arial, sans-serif;
      letter-spacing: 0;
      word-spacing: 0.02em;
      text-rendering: optimizeLegibility;
      -webkit-font-smoothing: antialiased;
    }
  </style>

  @stack('landing_head')

  <x-google-analytics />
  <x-facebook-pixel />
</head>

<body>
  @yield('landing_content')
</body>

</html>
