@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Book Orders</h1>
        <p class="mt-1 text-sm text-gray-600">Manage all book orders and customer details</p>
      </div>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated" x-data="{ filtersOpen: {{ request()->anyFilled(['search', 'status', 'book_id']) ? 'true' : 'false' }} }">
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
            @php
              $activeFiltersCount = collect([request('search'), request('status'), request('book_id')])
                  ->filter()
                  ->count();
            @endphp
            @if ($activeFiltersCount > 0)
              <span
                    class="inline-flex items-center justify-center rounded-full bg-primary-100 px-2 py-0.5 text-xs font-semibold text-primary-800">
                {{ $activeFiltersCount }}
              </span>
            @endif
          </button>
        </div>
        @if (request()->anyFilled(['search', 'status', 'book_id']))
          <x-ui.link href="{{ route('admin.book-orders.index') }}" variant="outline" size="sm">
            Clear All
          </x-ui.link>
        @endif
      </div>

      <!-- Filter Form -->
      <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 transform scale-100"
           x-transition:leave-end="opacity-0 transform scale-95">
        <form method="GET" action="{{ route('admin.book-orders.index') }}" id="filter-form" class="space-y-6 pt-6">
          <!-- Search Bar - Full Width -->
          <div>
            <x-ui.search name="search" placeholder="Search by name, email, phone, book name..."
                         value="{{ request('search') }}" />
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Status Filter -->
            <div>
              <x-forms.select name="status" label="Status" id="filter-status" :options="[
                  '' => 'All Statuses',
                  'pending' => 'Pending',
                  'processing' => 'Processing',
                  'shipped' => 'Shipped',
                  'delivered' => 'Delivered',
                  'cancelled' => 'Cancelled',
              ]" :value="request('status')"
                              placeholder="" />
            </div>

            <!-- Book Filter -->
            <div>
              <x-forms.select name="book_id" label="Book" id="filter-book-id" :options="['' => 'All Books'] + $books->toArray()" :value="request('book_id')"
                              placeholder="" />
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
          // Ensure form values are properly submitted
          $('#filter-form').on('submit', function(e) {
            // Disable empty select values to clean up URL
            $(this).find('select').each(function() {
              const val = $(this).val();
              if (val === '' || val === null || val === undefined) {
                $(this).prop('disabled', true);
              }
            });

            // Disable empty search input if it's empty
            const $searchInput = $('#search');
            const searchValue = $searchInput.val();
            if (!searchValue || searchValue.trim() === '') {
              $searchInput.prop('disabled', true);
            }
          });
        });
      </script>
    @endpush

    <!-- Orders Table -->
    @if ($orders->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Order ID</x-ui.table-cell>
              <x-ui.table-cell header>Customer</x-ui.table-cell>
              <x-ui.table-cell header>Book</x-ui.table-cell>
              <x-ui.table-cell header>Total</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header>Date</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($orders as $order)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">{{ $order->name }}</div>
                  <div class="text-xs text-gray-500">{{ $order->email }}</div>
                  <div class="text-xs text-gray-500">{{ $order->phone }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $order->book->title ?? 'Unknown Book' }}</div>
                  <div class="text-xs text-gray-500">Quantity: {{ $order->quantity }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">{{ format_price($order->total_amount) }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @php
                    $statusVariants = [
                        'pending' => 'warning',
                        'processing' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    ];
                    $variant = $statusVariants[$order->status] ?? 'secondary';
                  @endphp
                  <x-ui.badge :variant="$variant" size="sm">
                    {{ ucfirst($order->status) }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <x-ui.link href="{{ route('admin.book-orders.show', $order) }}" variant="outline" size="sm">
                    View
                  </x-ui.link>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$orders" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No orders found"
                          description="{{ request()->anyFilled(['search', 'status', 'book_id']) ? 'Try adjusting your filters to see more results.' : 'No book orders have been placed yet.' }}"
                          icon="shopping-bag">
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
