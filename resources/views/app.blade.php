<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @php
    $pageSeo = app(\App\Services\Seo\FrontendSeoResolver::class)->resolve(request());
  @endphp
  <title inertia>{{ $pageSeo['title'] ?? config('app.name', 'Laravel') }}</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <x-seo.head :seo="$pageSeo" />

  <!-- Fonts: Times New Roman + SutonnyMJ via vite resources/css/app.css -->

  <!-- SEO: Sitemap & RSS Feed -->
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

  <!-- Scripts -->
  @routes
  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
  @inertiaHead

  <!-- Meta Pixel Code -->
  <x-facebook-pixel />

  <!-- Google Analytics -->
  <x-google-analytics />

  <!-- Custom Styles for Header/Footer Colors -->
  <style>
    :root {
      --header-footer-bg-light: {{ \App\Models\Setting::get('header_footer_color_light', '#ffffff') }};
      --header-footer-bg-dark: {{ \App\Models\Setting::get('header_footer_color_dark', '#111827') }};
      --header-footer-text-light: {{ \App\Models\Setting::get('header_footer_text_color_light', '#111827') }};
      --header-footer-text-dark: {{ \App\Models\Setting::get('header_footer_text_color_dark', '#ffffff') }};
    }
  </style>
</head>

<body class="font-sans antialiased">
  @inertia
</body>

</html>
