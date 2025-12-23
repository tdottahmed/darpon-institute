@extends('layouts.admin')

@section('content')
  <div class="sm:flex sm:items-center sm:justify-between">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Enrollment #{{ $courseRegistration->id }}</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
        Registered on {{ $courseRegistration->created_at->format('F d, Y h:i A') }}
      </p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
      <a href="{{ route('admin.course-registrations.index') }}"
         class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 sm:w-auto">
        Back to List
      </a>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Enrollment Information -->
    <div class="space-y-6 lg:col-span-2">
      <!-- Course Details -->
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Course Details</h3>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center space-x-4">
              <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded bg-gray-100">
                @if ($courseRegistration->course->thumbnail)
                  <img src="{{ Storage::url($courseRegistration->course->thumbnail) }}" alt=""
                       class="h-full w-full object-cover">
                @else
                  <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">No Img</div>
                @endif
              </div>
              <div class="min-w-0 flex-1">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                  {{ $courseRegistration->course->title }}
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  {{ $courseRegistration->course->duration }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Student Details -->
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Student Information</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-0">
          <dl class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-700">
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">{{ $courseRegistration->name }}
              </dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $courseRegistration->email }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $courseRegistration->phone }}</dd>
            </div>
            <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</dt>
              <dd class="mt-1 whitespace-pre-wrap text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                {{ $courseRegistration->address }}</dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Payment Information -->
      @if ($courseRegistration->payment_gateway_id)
        <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Payment Information</h3>
          </div>
          <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-700">
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Method</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                  {{ $courseRegistration->paymentGateway->name ?? 'N/A' }}
                  <span
                        class="ml-2 text-xs text-gray-500">({{ ucfirst($courseRegistration->paymentGateway->type ?? '') }})</span>
                </dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Transaction ID</dt>
                <dd class="mt-1 font-mono text-sm text-gray-900 dark:text-white sm:col-span-2 sm:mt-0">
                  {{ $courseRegistration->transaction_id }}</dd>
              </div>
              <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</dt>
                <dd class="mt-1 sm:col-span-2 sm:mt-0">
                  @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                        'verified' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                    ];
                    $color = $statusColors[$courseRegistration->payment_status] ?? 'bg-gray-100 text-gray-800';
                  @endphp
                  <span
                        class="{{ $color }} inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                    {{ ucfirst($courseRegistration->payment_status) }}
                  </span>
                </dd>
              </div>
              @if ($courseRegistration->payment_screenshot)
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5">
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Screenshot</dt>
                  <dd class="mt-1 sm:col-span-2 sm:mt-0">
                    <a href="{{ Storage::url($courseRegistration->payment_screenshot) }}" target="_blank"
                       class="inline-flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                      <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                      View Screenshot
                    </a>
                  </dd>
                </div>
              @endif
            </dl>
          </div>
        </div>
      @endif
    </div>

    <!-- Actions -->
    <div class="space-y-6 lg:col-span-1">
      <div class="overflow-hidden bg-white shadow dark:bg-gray-800 sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">Enrollment Status</h3>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 dark:border-gray-700 sm:p-6">
          <form action="{{ route('admin.course-registrations.update', $courseRegistration) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
              <select id="status" name="status"
                      class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                <option value="pending" {{ $courseRegistration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $courseRegistration->status == 'confirmed' ? 'selected' : '' }}>Confirmed
                </option>
                <option value="completed" {{ $courseRegistration->status == 'completed' ? 'selected' : '' }}>Completed
                </option>
                <option value="cancelled" {{ $courseRegistration->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                </option>
              </select>
            </div>
            @if ($courseRegistration->payment_gateway_id)
              <div class="mt-4">
                <label for="payment_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment
                  Status</label>
                <select id="payment_status" name="payment_status"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white sm:text-sm">
                  <option value="pending" {{ $courseRegistration->payment_status == 'pending' ? 'selected' : '' }}>
                    Pending</option>
                  <option value="verified" {{ $courseRegistration->payment_status == 'verified' ? 'selected' : '' }}>
                    Verified</option>
                  <option value="rejected" {{ $courseRegistration->payment_status == 'rejected' ? 'selected' : '' }}>
                    Rejected</option>
                </select>
              </div>
            @endif
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
          <form action="{{ route('admin.course-registrations.destroy', $courseRegistration) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this enrollment? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex w-full justify-center rounded-md border border-red-300 bg-white px-4 py-2 text-base font-medium text-red-700 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:border-red-500 dark:bg-gray-700 dark:text-red-400 dark:hover:bg-gray-600 sm:text-sm">
              Delete Enrollment
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
