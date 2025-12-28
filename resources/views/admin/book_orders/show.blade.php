@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $bookOrder->id }}</h1>
        <p class="mt-1 text-sm text-gray-600">
          Placed on {{ $bookOrder->created_at->format('F d, Y h:i A') }}
        </p>
      </div>
      <x-ui.link href="{{ route('admin.book-orders.index') }}" variant="default" size="md">
        ← Back to List
      </x-ui.link>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- Main Content -->
      <div class="space-y-6 lg:col-span-2">
        <!-- Order Items -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Order Items</h3>
          <div class="flex items-center space-x-4">
            <div class="h-20 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
              @if ($bookOrder->book->cover_image)
                <img src="{{ Storage::url($bookOrder->book->cover_image) }}" alt=""
                     class="h-full w-full object-cover">
              @else
                <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">No Image</div>
              @endif
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-lg font-bold text-gray-900">{{ $bookOrder->book->title ?? 'Unknown Book' }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                Quantity: {{ $bookOrder->quantity }}
              </p>
              <p class="mt-2 text-lg font-semibold text-primary-600">
                {{ format_price($bookOrder->total_amount) }}
              </p>
            </div>
          </div>
        </x-card>

        <!-- Customer Information -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Customer Information</h3>
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Full Name</dt>
              <dd class="mt-1 text-sm font-medium text-gray-900">{{ $bookOrder->name }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $bookOrder->email }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $bookOrder->phone }}</dd>
            </div>
            <div class="sm:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Shipping Address</dt>
              <dd class="mt-1 whitespace-pre-wrap text-sm text-gray-900">{{ $bookOrder->address }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Shipping Method</dt>
              <dd class="mt-1 text-sm text-gray-900">
                {{ $bookOrder->shipping_method == 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Shipping Cost</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ format_price($bookOrder->shipping_cost) }}</dd>
            </div>
            @if ($bookOrder->note)
              <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Order Note</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $bookOrder->note }}</dd>
              </div>
            @endif
          </dl>
        </x-card>

        <!-- Payment Information -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Payment Information</h3>
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $bookOrder->payment_method ?? 'N/A' }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
              <dd class="mt-1 text-lg font-semibold text-primary-600">
                {{ format_price($bookOrder->total_amount) }}
              </dd>
            </div>
          </dl>
        </x-card>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6 lg:col-span-1">
        <!-- Order Status -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Order Status</h3>
          <div class="mb-4">
            @php
              $statusVariants = [
                  'pending' => 'warning',
                  'processing' => 'primary',
                  'shipped' => 'info',
                  'delivered' => 'success',
                  'cancelled' => 'danger',
              ];
              $variant = $statusVariants[$bookOrder->status] ?? 'secondary';
            @endphp
            <x-ui.badge :variant="$variant" size="md">
              {{ ucfirst($bookOrder->status) }}
            </x-ui.badge>
          </div>
          <form action="{{ route('admin.book-orders.update', $bookOrder) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
              <x-forms.select name="status" label="Update Status" :options="[
                  'pending' => 'Pending',
                  'processing' => 'Processing',
                  'shipped' => 'Shipped',
                  'delivered' => 'Delivered',
                  'cancelled' => 'Cancelled',
              ]" :value="$bookOrder->status" />
            </div>
            <div class="mt-4">
              <x-button type="submit" variant="primary" size="md" class="w-full">
                Update Status
              </x-button>
            </div>
          </form>
        </x-card>

        <!-- Danger Zone -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-red-600">Danger Zone</h3>
          <form action="{{ route('admin.book-orders.destroy', $bookOrder) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="danger" size="md" class="w-full">
              Delete Order
            </x-button>
          </form>
        </x-card>
      </div>
    </div>
  </div>
@endsection
