<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Something went wrong (500) - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-950 font-sans antialiased">
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

    <main class="flex flex-col items-center justify-center px-4 py-16 sm:py-24">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">500</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-5xl">Something went wrong</h1>
            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">We're sorry, but something went wrong on our end. Please try again later.</p>
            <div class="mt-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition-colors hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    Back to home
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </a>
            </div>
        </div>
    </main>

    {{-- Minimal footer --}}
    <footer class="mt-auto border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </footer>
</body>
</html>
