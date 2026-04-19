<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Not Found (404) - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-12px); }
        }
        @keyframes blink {
            0%, 90%, 100% { transform: scaleY(1); }
            95%            { transform: scaleY(0.05); }
        }
        .ghost-float  { animation: float 3.5s ease-in-out infinite; }
        .ghost-eyes   { animation: blink 4s ease-in-out infinite; }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up { animation: fade-in-up 0.6s ease-out both; }
        .delay-1    { animation-delay: 0.15s; }
        .delay-2    { animation-delay: 0.3s; }
        .delay-3    { animation-delay: 0.45s; }
    </style>
</head>
<body class="h-screen overflow-hidden bg-gray-50 dark:bg-gray-950 font-sans antialiased flex flex-col">

    {{-- Minimal header matching app layout --}}
    <header class="sticky top-0 left-0 right-0 z-50 border-b border-gray-200 bg-white/95 dark:bg-gray-900/95 dark:border-gray-800 backdrop-blur-md shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('darponbdv.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto">
                </a>
                <nav class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">Home</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="flex flex-1 flex-col items-center justify-center px-4 py-16 sm:py-24">
        <div class="mx-auto max-w-2xl text-center">

            {{-- Animated ghost illustration --}}
            <div class="ghost-float mb-8 flex justify-center fade-in-up">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 140" class="h-36 w-auto" aria-hidden="true">
                    {{-- Shadow --}}
                    <ellipse cx="60" cy="132" rx="28" ry="6" class="fill-gray-300 dark:fill-gray-700" opacity="0.5"/>
                    {{-- Ghost body --}}
                    <path d="M20 60 Q20 20 60 20 Q100 20 100 60 L100 115 Q87 105 75 115 Q62 125 60 115 Q58 125 45 115 Q33 105 20 115 Z"
                          class="fill-white dark:fill-gray-200" stroke="currentColor" stroke-width="1.5"
                          style="color: rgb(209 213 219);"/>
                    {{-- Eyes --}}
                    <g class="ghost-eyes">
                        <ellipse cx="44" cy="68" rx="8" ry="9" class="fill-gray-800 dark:fill-gray-900"/>
                        <ellipse cx="76" cy="68" rx="8" ry="9" class="fill-gray-800 dark:fill-gray-900"/>
                        {{-- Eye shine --}}
                        <circle cx="47" cy="65" r="2.5" fill="white"/>
                        <circle cx="79" cy="65" r="2.5" fill="white"/>
                    </g>
                    {{-- Mouth --}}
                    <path d="M50 84 Q60 92 70 84" stroke="#6b7280" stroke-width="2" fill="none" stroke-linecap="round"/>
                    {{-- 404 on ghost --}}
                    <text x="60" y="105" text-anchor="middle" font-family="'Times New Roman', Times, serif" font-size="11"
                          font-weight="600" class="fill-gray-400 dark:fill-gray-500">404</text>
                </svg>
            </div>

            {{-- Error label --}}
            <p class="text-sm font-semibold uppercase tracking-wider text-primary-600 dark:text-primary-400 fade-in-up delay-1">404 – Not Found</p>

            {{-- Heading --}}
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-5xl fade-in-up delay-1">
                Looks like this page vanished
            </h1>

            {{-- Description --}}
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 fade-in-up delay-2">
                The page you're looking for doesn't exist, was moved, or is temporarily unavailable.
            </p>

            {{-- Action --}}
            <div class="mt-10 flex justify-center fade-in-up delay-3">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition-colors hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Back to Home
                </a>
            </div>

        </div>
    </main>

    {{-- Minimal footer --}}
    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
