@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Payment Gateways</h1>
        <p class="mt-1 text-sm text-gray-600">Manage payment methods</p>
      </div>
      <x-ui.link href="{{ route('admin.payment-gateways.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Payment Gateway
      </x-ui.link>
    </div>

    <!-- Payment Gateways Table -->
    @if ($paymentGateways->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Name</x-ui.table-cell>
              <x-ui.table-cell header>Type</x-ui.table-cell>
              <x-ui.table-cell header>Account Number</x-ui.table-cell>
              <x-ui.table-cell header>Order</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($paymentGateways as $gateway)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">{{ $gateway->name }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge variant="secondary" size="sm">
                    {{ ucfirst($gateway->type) }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $gateway->account_number ?? 'N/A' }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $gateway->order }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$gateway->status ? 'success' : 'secondary'" size="sm">
                    {{ $gateway->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.payment-gateways.edit', $gateway) }}" variant="outline"
                               size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.payment-gateways.destroy', $gateway) }}" method="POST"
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
        <x-ui.pagination :paginator="$paymentGateways" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No payment gateways found" description="Get started by creating a new payment gateway."
                          icon="credit-card">
          <x-ui.link href="{{ route('admin.payment-gateways.create') }}" variant="primary" size="md">
            Add Payment Gateway
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
