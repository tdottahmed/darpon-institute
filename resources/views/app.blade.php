<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png" />

  <!-- Global Meta Configuration -->
  @php
    $seoTitle = \App\Models\Setting::get('seo_meta_title') ?: config('app.name', 'Laravel');
    $seoDesc = \App\Models\Setting::get('seo_meta_description');
    $seoKeywords = \App\Models\Setting::get('seo_meta_keywords');
    $seoAuthor = \App\Models\Setting::get('seo_meta_author');
    $seoOgImage = \App\Models\Setting::get('seo_og_image');
  @endphp

  @if($seoDesc) <meta name="description" content="{{ $seoDesc }}"> @endif
  @if($seoKeywords) <meta name="keywords" content="{{ $seoKeywords }}"> @endif
  @if($seoAuthor) <meta name="author" content="{{ $seoAuthor }}"> @endif

  <!-- Open Graph -->
  <meta property="og:title" content="{{ $seoTitle }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">
  @if($seoDesc) <meta property="og:description" content="{{ $seoDesc }}"> @endif
  @if($seoOgImage) <meta property="og:image" content="{{ \Illuminate\Support\Facades\Storage::url($seoOgImage) }}"> @endif

  <!-- Fonts: Times New Roman + SutonnyMJ via vite resources/css/app.css -->

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
  @routes
  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
  @inertiaHead

  <!-- Meta Pixel Code -->
  @php
    $metaPixelId = \App\Models\Setting::get('meta_pixel_id');
    $metaPixelEnabled = \App\Models\Setting::get('meta_pixel_enabled', '0');
  @endphp
  @if($metaPixelId && ($metaPixelEnabled == '1' || $metaPixelEnabled == 1))
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '{{ $metaPixelId }}');
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none"
           src="https://www.facebook.com/tr?id={{ $metaPixelId }}&ev=PageView&noscript=1"/>
    </noscript>
  @endif

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
