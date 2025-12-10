<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-100 font-sans antialiased">
  <div class="min-h-screen">
    <!-- Navigation -->
    <nav class="border-b border-gray-200 bg-white">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
          <div class="flex">
            <div class="flex flex-shrink-0 items-center">
              <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
            </div>
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <a href="{{ route('admin.dashboard') }}"
                 class="inline-flex items-center border-b-2 border-indigo-400 px-1 pt-1 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out focus:border-indigo-700 focus:outline-none">
                Dashboard
              </a>
            </div>
          </div>

          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <div class="relative ml-3">
              <div class="flex items-center">
                <span class="mr-4 text-sm text-gray-700">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                    Logout
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <main class="py-6">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        @if (session('status'))
          <div class="relative mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700"
               role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
          </div>
        @endif

        @yield('content')
      </div>
    </main>
  </div>
</body>

</html>
