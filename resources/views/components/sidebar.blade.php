@php
  $menuItems = [
      [
          'name' => 'Dashboard',
          'href' => route('admin.dashboard'),
          'icon' => 'dashboard',
          'active' => request()->routeIs('admin.dashboard'),
      ],
      [
          'name' => 'Users',
          'href' => '#',
          'icon' => 'users',
          'active' => false,
      ],
      [
          'name' => 'Courses',
          'href' => '#',
          'icon' => 'courses',
          'active' => false,
      ],
      [
          'name' => 'Analytics',
          'href' => '#',
          'icon' => 'analytics',
          'active' => false,
      ],
      [
          'name' => 'Settings',
          'href' => '#',
          'icon' => 'settings',
          'active' => false,
      ],
  ];
@endphp

<!-- Sidebar Backdrop (Mobile) -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/80 lg:hidden" @click="sidebarOpen = false"
     style="display: none;"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-xl transition-transform duration-300 lg:static lg:inset-auto lg:z-auto lg:translate-x-0">
  <!-- Logo -->
  <div class="flex h-16 items-center justify-between border-b border-gray-700 bg-gray-900 px-4 lg:px-6">
    <h1
        class="bg-gradient-to-r from-primary-400 via-secondary-400 to-accent-400 bg-clip-text text-lg font-bold text-transparent lg:text-xl">
      {{ config('app.name', 'Darpon') }}
    </h1>
    <button @click="sidebarOpen = false"
            class="rounded-md p-1 text-gray-400 transition-colors hover:bg-gray-800 hover:text-white lg:hidden">
      <x-icon name="close" class="h-6 w-6" />
    </button>
  </div>

  <!-- Navigation -->
  <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
    @foreach ($menuItems as $item)
      <x-sidebar-link :href="$item['href']" :icon="$item['icon']" :active="$item['active']">
        {{ $item['name'] }}
      </x-sidebar-link>
    @endforeach
  </nav>

  <!-- User Info (Bottom Sidebar) -->
  <div class="border-t border-gray-700 bg-gray-900/50 p-4">
    <div class="flex items-center gap-3">
      <div
           class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-sm font-bold text-white shadow-lg">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </div>
      <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-medium text-white">{{ Auth::user()->name }}</p>
        <p class="truncate text-xs text-gray-400">{{ Auth::user()->email }}</p>
      </div>
    </div>
  </div>
</aside>
