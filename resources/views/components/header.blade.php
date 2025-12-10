<div class="sticky top-0 z-20 flex h-16 flex-shrink-0 border-b border-gray-200 bg-white shadow-sm">
  <button type="button"
          class="border-r border-gray-200 px-4 text-gray-500 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden"
          @click="sidebarOpen = true">
    <span class="sr-only">Open sidebar</span>
    <x-icon name="menu" class="h-6 w-6" />
  </button>

  <div class="flex flex-1 items-center justify-between px-4 sm:px-6 lg:px-8">
    <div class="flex items-center">
      <h2 class="text-xl font-semibold text-gray-900">
        {{ $header ?? 'Dashboard' }}
      </h2>
    </div>
    <div class="ml-4 flex items-center space-x-4 md:ml-6">
      <!-- Notifications -->
      <button type="button"
              class="relative rounded-full bg-white p-2 text-gray-400 transition-colors hover:bg-gray-50 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
        <span class="sr-only">View notifications</span>
        <x-icon name="notifications" class="h-6 w-6" />
        <span class="absolute right-0 top-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
      </button>

      <!-- Profile Dropdown -->
      <div class="relative" x-data="{ open: false }">
        <button type="button"
                class="flex max-w-xs items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                @click="open = !open">
          <span class="sr-only">Open user menu</span>
          <div
               class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-white bg-gradient-to-br from-primary-500 to-secondary-500 text-sm font-bold text-white shadow-md">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
             @click.away="open = false" style="display: none;">
          <div class="border-b border-gray-100 px-4 py-3">
            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
            <p class="truncate text-xs text-gray-500">{{ Auth::user()->email }}</p>
          </div>
          <a href="#"
             class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-50">
            <x-icon name="profile" class="mr-3 h-4 w-4 text-gray-400" />
            Your Profile
          </a>
          <a href="#"
             class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-50">
            <x-icon name="settings" class="mr-3 h-4 w-4 text-gray-400" />
            Settings
          </a>
          <div class="my-1 border-t border-gray-100"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center px-4 py-2 text-left text-sm text-red-600 transition-colors hover:bg-red-50">
              <x-icon name="logout" class="mr-3 h-4 w-4 text-red-400" />
              Sign out
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
