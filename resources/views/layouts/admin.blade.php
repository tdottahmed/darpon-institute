<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Darpon') }} - Admin Panel</title>
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png" />
  <!-- Fonts: Times New Roman + SutonnyMJ via vite resources/css/app.css -->

  <!-- Scripts -->
  @vite(['resources/css/app.css'])

  @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false }">
  <div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <x-sidebar />

    <!-- Main Content Wrapper -->
    <div class="flex min-w-0 flex-1 flex-col lg:ml-72">
      <!-- Header -->
      <x-header :header="$header ?? 'Dashboard'" />

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-8xl mx-auto px-2 py-6 sm:px-6 lg:px-6">
          <!-- Flash Messages -->
          <x-flash-message />
          @yield('content')
        </div>
      </main>
      <!-- Footer -->
      <footer class="border-t border-gray-200 bg-white p-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
      </footer>
    </div>
  </div>

  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/alpine.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <x-sweet-alert />
  @stack('scripts')
</body>

</html>
