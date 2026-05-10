<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @php
    $pageSeo = $seo ?? [];
  @endphp
  @if(($pageSeo['title'] ?? '') !== '')
    <title>{{ $pageSeo['title'] }}</title>
    <x-seo.head :seo="$pageSeo" />
  @else
    @if($landingPage->meta_description ?? null)
      <meta name="description" content="{{ $landingPage->meta_description }}">
    @endif
    <title>{{ $landingPage->meta_title ?? ($landingPage->book->title ?? $landingPage->course->title ?? config('app.name', 'Darpon')) }}</title>
  @endif

  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />

  @php
    $sitemapUrl = \App\Models\Setting::get('sitemap_url');
    $rssFeedUrl = \App\Models\Setting::get('rss_feed_url');
  @endphp
  <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap.index', absolute: true) }}">
  @if($sitemapUrl)
    <link rel="sitemap" type="application/xml" href="{{ $sitemapUrl }}">
  @endif
  @if($rssFeedUrl)
    <link rel="alternate" type="application/rss+xml" title="RSS Feed" href="{{ $rssFeedUrl }}">
  @endif

  @vite(['resources/css/app.css'])
  <script src="{{ asset('js/alpine.min.js') }}" defer></script>

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link href="https://fonts.maateen.me/nikosh/font.css" rel="stylesheet">

  @include('frontend.partials.landing.styles')

  <style>
    .bengali-text {
      font-family: 'Nikosh', 'Noto Sans Bengali', 'Inter', 'Segoe UI', Arial, sans-serif;
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
