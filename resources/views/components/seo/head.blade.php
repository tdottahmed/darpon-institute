@props([
    'seo' => [],
])

@php
    $author = null;
    try {
        $author = \App\Models\Setting::get('seo_meta_author');
    } catch (\Throwable) {
    }
@endphp

@if(!empty($seo['title']))
  <title>{{ $seo['title'] }}</title>
@endif

@if(!empty($seo['description']))
  <meta head-key="seo-description" name="description" content="{{ $seo['description'] }}">
@endif

@if(!empty($seo['keywords']))
  <meta head-key="seo-keywords" name="keywords" content="{{ $seo['keywords'] }}">
@endif

@if($author)
  <meta head-key="seo-author" name="author" content="{{ $author }}">
@endif

@if(!empty($seo['canonical_url']))
  <link head-key="seo-canonical" rel="canonical" href="{{ $seo['canonical_url'] }}">
@endif

@if(!empty($seo['og_title']))
  <meta head-key="seo-og-title" property="og:title" content="{{ $seo['og_title'] }}">
@endif
@if(!empty($seo['og_description']))
  <meta head-key="seo-og-description" property="og:description" content="{{ $seo['og_description'] }}">
@endif
@if(!empty($seo['og_type']))
  <meta head-key="seo-og-type" property="og:type" content="{{ $seo['og_type'] }}">
@endif
@if(!empty($seo['og_url']))
  <meta head-key="seo-og-url" property="og:url" content="{{ $seo['og_url'] }}">
@endif
@if(!empty($seo['og_image']))
  <meta head-key="seo-og-image" property="og:image" content="{{ $seo['og_image'] }}">
@endif
@if(!empty($seo['og_site_name']))
  <meta head-key="seo-og-site-name" property="og:site_name" content="{{ $seo['og_site_name'] }}">
@endif

@if(!empty($seo['twitter_card']))
  <meta head-key="seo-twitter-card" name="twitter:card" content="{{ $seo['twitter_card'] }}">
@endif
@if(!empty($seo['twitter_title']))
  <meta head-key="seo-twitter-title" name="twitter:title" content="{{ $seo['twitter_title'] }}">
@endif
@if(!empty($seo['twitter_description']))
  <meta head-key="seo-twitter-description" name="twitter:description" content="{{ $seo['twitter_description'] }}">
@endif
@if(!empty($seo['twitter_image']))
  <meta head-key="seo-twitter-image" name="twitter:image" content="{{ $seo['twitter_image'] }}">
@endif

@foreach($seo['json_ld'] ?? [] as $index => $schema)
  @if(is_array($schema) && $schema !== [])
    <script head-key="seo-json-ld-{{ $index }}" type="application/ld+json" id="seo-json-ld-{{ $index }}">@json($schema)</script>
  @endif
@endforeach
