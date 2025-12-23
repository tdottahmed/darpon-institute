@extends('layouts.admin')

@section('content')
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Order Details #{{ $bookOrder->id }}</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
        Placed on {{ $bookOrder->created_at->format('F d, Y h:i A') }}
      </p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
      <a href="{{ route('admin.book-orders.index') }}"
         class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:w-auto">
        Back to List
      </a>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Order Information -->
    <div class="space-y-6 lg:col-span-2">
      <!-- Items -->
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Order Items</h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center space-x-4">
              <div class="h-16 w-12 flex-shrink-0 overflow-hidden rounded bg-gray-100">
                @if ($bookOrder->book->cover_image)
                  <img src="{{ Storage::url($bookOrder->book->cover_image) }}" alt=""
                       class="h-full w-full object-cover">
                @else
                  <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">No Img</div>
                @endif
              </div>
              <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                  {{ $bookOrder->book->title }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  Quantity: {{ $bookOrder->quantity }}
                </p>
              </div>
              <div class="inline-flex items-center text-sm font-semibold text-gray-900 dark:text-white">
                {{ format_price($bookOrder->total_amount) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Customer Details -->
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Customer Information</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-0">
          <dl class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-700">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $bookOrder->name }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $bookOrder->email }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $bookOrder->phone }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Address</dt>
              <dd class="mt-1 whitespace-pre-wrap text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $bookOrder->address }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Method</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $bookOrder->shipping_method == 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}
                ({{ format_price($bookOrder->shipping_cost) }})
              </dd>
            </div>
            @if ($bookOrder->note)
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Note</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $bookOrder->note }}</dd>
              </div>
            @endif
          </dl>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="space-y-6 lg:col-span-1">
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Order Status</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-6">
          <form action="{{ route('admin.book-orders.update', $bookOrder) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
              <select id="status" name="status"
                      class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                <option value="pending" {{ $bookOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $bookOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $bookOrder->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $bookOrder->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $bookOrder->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </div>
            <div class="mt-4">
              <button type="submit"
                      class="inline-flex w-full justify-center rounded-md border border-transparent bg-primary-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:text-sm">
                Update Status
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-red-600 dark:text-red-400">Danger Zone</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-6">
          <form action="{{ route('admin.book-orders.destroy', $bookOrder) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex w-full justify-center rounded-md border border-red-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-500 dark:bg-gray-700 dark:text-red-400 dark:hover:bg-gray-600 sm:text-sm">
              Delete Order
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
