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

        <!-- Invoice -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Invoice</h3>
          <p class="mb-4 text-sm text-gray-600">View or print the invoice for this order.</p>
          <x-ui.link href="{{ route('admin.book-orders.invoice', $bookOrder) }}" variant="primary" size="md" class="w-full justify-center" target="_blank">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            View Invoice
          </x-ui.link>
        </x-card>

        <!-- Fraud Check -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Fraud Check</h3>
          @if ($fraudCheckHistory)
            @php
              $successRatio = $fraudCheckHistory->success_ratio ?? 0;
              $totalOrders = $fraudCheckHistory->total_orders ?? 0;
              $cancelOrders = $fraudCheckHistory->cancel_orders ?? 0;
              $isHighRisk = $successRatio < 50 || $cancelOrders > $totalOrders * 0.5;
              $isMediumRisk = $successRatio >= 50 && $successRatio < 70;
              $isLowRisk = $successRatio >= 70;
            @endphp
            <div class="mb-4 space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-700">Success Ratio</span>
                <span class="text-sm font-bold {{ $isHighRisk ? 'text-red-600' : ($isMediumRisk ? 'text-yellow-600' : 'text-green-600') }}">
                  {{ number_format($successRatio, 2) }}%
                </span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-700">Total Orders</span>
                <span class="text-sm text-gray-900">{{ $totalOrders }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-gray-700">Cancelled Orders</span>
                <span class="text-sm text-gray-900">{{ $cancelOrders }}</span>
              </div>
              @if ($isHighRisk)
                <x-ui.badge variant="danger" size="sm" class="w-full justify-center">High Risk</x-ui.badge>
              @elseif($isMediumRisk)
                <x-ui.badge variant="warning" size="sm" class="w-full justify-center">Medium Risk</x-ui.badge>
              @else
                <x-ui.badge variant="success" size="sm" class="w-full justify-center">Low Risk</x-ui.badge>
              @endif
              @if ($fraudCheckHistory->last_checked_at)
                <p class="text-xs text-gray-500">
                  Last checked: {{ $fraudCheckHistory->last_checked_at->diffForHumans() }}
                </p>
              @endif
            </div>
            @if ($fraudCheckHistory->data)
              <details class="mt-4">
                <summary class="cursor-pointer text-sm font-medium text-gray-700 hover:text-gray-900">
                  View Detailed Data
                </summary>
                <div class="mt-2 rounded-md bg-gray-50 p-3 text-xs">
                  <pre class="whitespace-pre-wrap">{{ json_encode($fraudCheckHistory->data, JSON_PRETTY_PRINT) }}</pre>
                </div>
              </details>
            @endif
          @else
            <p class="mb-4 text-sm text-gray-600">No fraud check history available.</p>
          @endif
          <form action="{{ route('admin.book-orders.check-fraud', $bookOrder) }}" method="POST">
            @csrf
            <x-button type="submit" variant="outline" size="md" class="w-full">
              <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Check Fraud
            </x-button>
          </form>
        </x-card>

        <!-- Consignment -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Consignment</h3>
          @if ($bookOrder->consignment_id || $bookOrder->tracking_code)
            <div class="mb-4 space-y-3">
              @if ($bookOrder->consignment_id)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Consignment ID</dt>
                  <dd class="mt-1 text-sm font-medium text-gray-900">{{ $bookOrder->consignment_id }}</dd>
                </div>
              @endif
              @if ($bookOrder->tracking_code)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Tracking Code</dt>
                  <dd class="mt-1 text-sm font-medium text-primary-600">{{ $bookOrder->tracking_code }}</dd>
                </div>
              @endif
              @if ($bookOrder->consignment_created_at)
                <div>
                  <dt class="text-sm font-medium text-gray-500">Created At</dt>
                  <dd class="mt-1 text-sm text-gray-900">
                    {{ $bookOrder->consignment_created_at->format('M d, Y h:i A') }}
                  </dd>
                </div>
              @endif
            </div>
            <x-ui.badge variant="success" size="sm" class="w-full justify-center mb-4">
              Consignment Created
            </x-ui.badge>
          @else
            <p class="mb-4 text-sm text-gray-600">No consignment created yet.</p>
          @endif

          <!-- Create Consignment Form -->
          <form action="{{ route('admin.book-orders.update', $bookOrder) }}" method="POST" id="consignmentForm"
                onsubmit="return confirm('Are you sure you want to create a consignment? This will send the order to Steadfast Courier.');">
            @csrf
            @method('PUT')
            <input type="hidden" name="create_consignment" value="1">
            <div class="space-y-4">
              <div>
                <x-forms.input name="name" label="Customer Name" :value="$bookOrder->name" required />
              </div>
              <div>
                <x-forms.input name="phone" label="Phone Number" :value="$bookOrder->phone" required />
              </div>
              <div>
                <x-forms.textarea name="address" label="Shipping Address" :value="$bookOrder->address" rows="3" required />
              </div>
              <x-button type="submit" variant="primary" size="md" class="w-full" :disabled="!!$bookOrder->consignment_id">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 13l4 4L19 7" />
                </svg>
                {{ $bookOrder->consignment_id ? 'Consignment Already Created' : 'Create Consignment' }}
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
