@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Shipping Methods</h1>
        <p class="mt-1 text-sm text-gray-600">Manage shipping options</p>
      </div>
      <x-ui.link href="{{ route('admin.shipping-methods.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Shipping Method
      </x-ui.link>
    </div>

    <!-- Shipping Methods Table -->
    @if ($shippingMethods->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Name</x-ui.table-cell>
              <x-ui.table-cell header>Price</x-ui.table-cell>
              <x-ui.table-cell header>Duration</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($shippingMethods as $method)
              <x-ui.table-row>
                <x-ui.table-cell>
                    <div class="text-sm font-medium text-gray-900">{{ $method->name }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                    <div class="text-sm font-medium text-gray-900">${{ number_format($method->price, 2) }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                    <div class="text-sm text-gray-500">{{ $method->duration ?? 'N/A' }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$method->status ? 'success' : 'secondary'" size="sm">
                    {{ $method->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.shipping-methods.edit', $method) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.shipping-methods.destroy', $method) }}" method="POST"
                          class="delete-form inline">
                      @csrf
                      @method('DELETE')
                      <button type="button"
                              class="delete-confirm inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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
        <x-ui.pagination :paginator="$shippingMethods" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No shipping methods found" description="Get started by creating a new shipping method."
                          icon="truck">
          <x-ui.link href="{{ route('admin.shipping-methods.create') }}" variant="primary" size="md">
            Add Shipping Method
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
