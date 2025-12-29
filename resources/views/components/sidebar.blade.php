@php
  // Organize menu items into groups for better UX
  $menuGroups = [
      'Main' => [
          [
              'name' => 'Dashboard',
              'href' => route('admin.dashboard'),
              'icon' => 'dashboard',
              'active' => request()->routeIs('admin.dashboard'),
          ],
      ],
      'Content' => [
          [
              'name' => 'Courses',
              'href' => route('admin.courses.index'),
              'icon' => 'courses',
              'active' => request()->routeIs('admin.courses.*'),
          ],
          [
              'name' => 'Books',
              'href' => route('admin.books.index'),
              'icon' => 'books',
              'active' => request()->routeIs('admin.books.*'),
          ],
          [
              'name' => 'Video Blogs',
              'href' => route('admin.video-blogs.index'),
              'icon' => 'video',
              'active' => request()->routeIs('admin.video-blogs.*'),
          ],
          [
              'name' => 'Galleries',
              'href' => route('admin.galleries.index'),
              'icon' => 'photograph',
              'active' => request()->routeIs('admin.galleries.*'),
          ],
          [
              'name' => 'Testimonials',
              'href' => route('admin.testimonials.index'),
              'icon' => 'user-group',
              'active' => request()->routeIs('admin.testimonials.*'),
          ],
      ],
      'Management' => [
          [
              'name' => 'Users',
              'href' => route('admin.users.index'),
              'icon' => 'users',
              'active' => request()->routeIs('admin.users.*'),
          ],
          [
              'name' => 'Book Orders',
              'href' => route('admin.book-orders.index'),
              'icon' => 'orders',
              'active' => request()->routeIs('admin.book-orders.*'),
          ],
          [
            'name' => 'Enrollments',
            'href' => route('admin.course-registrations.index'),
            'icon' => 'enrollments',
            'active' => request()->routeIs('admin.course-registrations.index') || request()->routeIs('admin.course-registrations.create') || request()->routeIs('admin.course-registrations.show'),
          ],
          [
            'name' => 'Installments',
            'href' => route('admin.course-registrations.installments'),
            'icon' => 'calendar',
            'active' => request()->routeIs('admin.course-registrations.installments'),
          ],
      ],
      'Settings' => [
          [
              'name' => 'General Settings',
              'href' => route('admin.settings.index'),
              'icon' => 'cog',
              'active' => request()->routeIs('admin.settings.*'),
          ],
          [
              'name' => 'Payment Gateways',
              'href' => route('admin.payment-gateways.index'),
              'icon' => 'credit-card',
              'active' => request()->routeIs('admin.payment-gateways.*'),
          ],
          [
              'name' => 'Shipping Methods',
              'href' => route('admin.shipping-methods.index'),
              'icon' => 'truck',
              'active' => request()->routeIs('admin.shipping-methods.*'),
          ],
          [
              'name' => 'Frontend CMS',
              'href' => route('admin.frontend-content.index'),
              'icon' => 'template',
              'active' => request()->routeIs('admin.frontend-content.*'),
          ],
      ],
  ];
@endphp

<!-- Sidebar Backdrop (Mobile) -->
<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm lg:hidden"
     @click="sidebarOpen = false" style="display: none;">
</div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-gray-200 bg-white shadow-2xl transition-transform duration-300 ease-in-out dark:border-gray-800 dark:bg-gray-900 lg:static lg:inset-auto lg:z-auto lg:translate-x-0">

  <!-- Logo Section -->
  <div
       class="flex h-16 items-center justify-between border-b border-gray-200 bg-gradient-to-r from-primary-50 to-secondary-50 px-4 dark:border-gray-800 dark:from-gray-800 dark:to-gray-900 lg:px-6">
    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3">
      <div class="flex-shrink-0">
        <img src="{{ asset('darponbdv.png') }}" alt="{{ config('app.name', 'Darpon') }}"
             class="h-10 w-auto transition-transform duration-200 group-hover:scale-105"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
      </div>

    </a>
    <button @click="sidebarOpen = false"
            class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white lg:hidden">
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Navigation -->
  <nav
       class="scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700 scrollbar-track-transparent flex-1 space-y-6 overflow-y-auto px-4 py-6">
    @foreach ($menuGroups as $groupName => $items)
      <div class="space-y-1">
        @if ($groupName !== 'Main')
          <h3 class="mb-2 px-3 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
            {{ $groupName }}
          </h3>
        @endif
        <div class="space-y-1">
          @foreach ($items as $item)
            <x-sidebar-link :href="$item['href']" :icon="$item['icon']" :active="$item['active']">
              {{ $item['name'] }}
            </x-sidebar-link>
          @endforeach
        </div>
      </div>
    @endforeach
  </nav>

  <!-- User Info (Bottom Sidebar) -->
  <div class="border-t border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-gray-800/50">
    <div class="flex items-center gap-3">
      <div
           class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 via-secondary-500 to-accent-500 text-sm font-bold text-white shadow-lg ring-2 ring-white dark:ring-gray-900">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
      </div>
      <div class="min-w-0 flex-1">
        <p class="truncate text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
      </div>
      <a href="{{ route('profile.edit') }}"
         class="flex-shrink-0 rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300"
         title="Profile Settings">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </a>
    </div>
  </div>
</aside>
