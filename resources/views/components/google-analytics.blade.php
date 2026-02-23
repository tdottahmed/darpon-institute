@php
    // Get analytics ID from admin settings (database) first, then fallback to .env config
    $analyticsId = \App\Models\Setting::get('google_analytics_id') ?: config('services.google.analytics_id');
@endphp

@if($analyticsId)
    @if(str_starts_with($analyticsId, 'G-'))
        <!-- Google Analytics 4 (GA4) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $analyticsId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $analyticsId }}');
        </script>
    @elseif(str_starts_with($analyticsId, 'UA-'))
        <!-- Universal Analytics (Legacy) -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
            ga('create', '{{ $analyticsId }}', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
@endif
