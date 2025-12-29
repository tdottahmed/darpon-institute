@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Landing Pages</h1>
        <p class="mt-1 text-sm text-gray-600">Manage custom landing pages for courses and books</p>
      </div>
      <x-ui.link href="{{ route('admin.landing-pages.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create Landing Page
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated" x-data="{ filtersOpen: {{ request()->anyFilled(['search', 'product_type', 'status']) ? 'true' : 'false' }} }">
      <!-- Filter Header -->
      <div class="flex items-center justify-between border-b border-gray-200 pb-4">
        <div class="flex items-center gap-3">
          <button type="button" @click="filtersOpen = !filtersOpen"
                  class="flex items-center gap-2 text-sm font-medium text-gray-700 transition-colors hover:text-gray-900">
            <svg class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-180': filtersOpen }" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            <span>Filters</span>
            @if (request()->anyFilled(['search', 'product_type', 'status']))
              <x-ui.badge variant="primary"
                          size="sm">{{ collect(['search', 'product_type', 'status'])->filter(fn($key) => request()->filled($key))->count() }}</x-ui.badge>
            @endif
          </button>
        </div>
        @if (request()->anyFilled(['search', 'product_type', 'status']))
          <a href="{{ route('admin.landing-pages.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
            Clear all
          </a>
        @endif
      </div>

      <!-- Filter Form -->
      <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 transform scale-100"
           x-transition:leave-end="opacity-0 transform scale-95">
        <form method="GET" action="{{ route('admin.landing-pages.index') }}" id="filter-form"
              class="space-y-6 pt-6">
          <!-- Search Bar -->
          <div>
            <x-ui.search name="search" placeholder="Search by title or slug..." value="{{ request('search') }}" />
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Product Type Filter -->
            <div>
              <x-forms.select name="product_type" label="Product Type" id="filter-product-type" :options="[
                  '' => 'All Types',
                  'course' => 'Course',
                  'book' => 'Book',
              ]" :value="request('product_type')" placeholder="" />
            </div>

            <!-- Status Filter -->
            <div>
              <x-forms.select name="status" label="Status" id="filter-status" :options="[
                  '' => 'All Statuses',
                  'active' => 'Active',
                  'inactive' => 'Inactive',
              ]" :value="request('status')" placeholder="" />
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-4">
            <x-button type="submit" variant="primary" size="md">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
              </svg>
              Apply Filters
            </x-button>
          </div>
        </form>
      </div>
    </x-card>

    @push('scripts')
      <script>
        $(document).ready(function() {
          $('#filter-form').on('submit', function(e) {
            $(this).find('select').each(function() {
              const val = $(this).val();
              if (val === '' || val === null || val === undefined) {
                $(this).prop('disabled', true);
              }
            });

            const $searchInput = $('#search');
            const searchValue = $searchInput.val();
            if (!searchValue || searchValue.trim() === '') {
              $searchInput.prop('disabled', true);
            }
          });
        });
      </script>
    @endpush

    <!-- Landing Pages Table -->
    @if ($landingPages->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Title</x-ui.table-cell>
              <x-ui.table-cell header>Product</x-ui.table-cell>
              <x-ui.table-cell header>Type</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header>URL</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($landingPages as $landingPage)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    @if ($landingPage->hero_image)
                      <img src="{{ Storage::url($landingPage->hero_image) }}" alt=""
                           class="mr-3 h-10 w-10 rounded-lg object-cover">
                    @else
                      <div
                           class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                        </svg>
                      </div>
                    @endif
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ $landingPage->title }}</div>
                      <div class="text-xs text-gray-500">{{ $landingPage->slug }}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($landingPage->product_type === 'course' && $landingPage->course)
                    <div class="text-sm text-gray-900">{{ $landingPage->course->title }}</div>
                  @elseif ($landingPage->product_type === 'book' && $landingPage->book)
                    <div class="text-sm text-gray-900">{{ $landingPage->book->title }}</div>
                  @else
                    <span class="text-sm text-gray-400">N/A</span>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$landingPage->product_type === 'course' ? 'primary' : 'secondary'" size="sm">
                    {{ ucfirst($landingPage->product_type) }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$landingPage->status ? 'success' : 'secondary'" size="sm">
                    {{ $landingPage->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($landingPage->status)
                    <a href="{{ route('landing-page.show', $landingPage->slug) }}" target="_blank"
                       class="text-sm text-primary-600 hover:text-primary-900">
                      View Page
                    </a>
                  @else
                    <span class="text-sm text-gray-400">Inactive</span>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.landing-pages.show', $landingPage) }}" variant="outline" size="sm">
                      View
                    </x-ui.link>
                    <x-ui.link href="{{ route('admin.landing-pages.edit', $landingPage) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.landing-pages.destroy', $landingPage) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this landing page?');"
                          class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Delete
                      </button>
                    </form>
                  </div>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$landingPages" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No landing pages found"
                          description="{{ request()->anyFilled(['search', 'product_type', 'status']) ? 'Try adjusting your filters to see more results.' : 'Get started by creating a new landing page.' }}"
                          icon="template">
          @if (!request()->anyFilled(['search', 'product_type', 'status']))
            <x-ui.link href="{{ route('admin.landing-pages.create') }}" variant="primary" size="md">
              Create Landing Page
            </x-ui.link>
          @endif
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection

