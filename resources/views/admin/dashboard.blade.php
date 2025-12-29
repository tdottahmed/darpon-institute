@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Welcome Section -->
    <x-card variant="elevated">
      <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div class="flex-1">
          <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
          <p class="mt-2 text-sm text-gray-600">Here's what's happening with your platform today.</p>
        </div>
        <div class="flex gap-3">
          <x-ui.link href="{{ route('admin.book-orders.index') }}" variant="outline" size="md">
            Book Orders
          </x-ui.link>
          <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="outline" size="md">
            Enrollments
          </x-ui.link>
        </div>
      </div>
    </x-card>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
      <x-stat-card title="Total Book Orders" :value="number_format($bookOrdersStats['total'])" icon="orders" color="primary"
                   :trend="'Today: ' . $bookOrdersStats['today_orders'] . ' orders'" />
      <x-stat-card title="Book Revenue" :value="format_price($bookOrdersStats['total_revenue'], false)" icon="orders" color="secondary"
                   :trend="'Today: ' . format_price($bookOrdersStats['today_revenue'], false)" />
      <x-stat-card title="Course Enrollments" :value="number_format($courseRegistrationsStats['total'])" icon="enrollments" color="accent"
                   :trend="'Today: ' . $courseRegistrationsStats['today_registrations'] . ' enrollments'" />
      <x-stat-card title="Pending Installments" :value="number_format($installmentsStats['pending'])" icon="calendar" color="light"
                   :trend="'Overdue: ' . $installmentsStats['overdue'] . ' installments'" />
    </div>

    <!-- Book Orders Section -->
    <x-card variant="elevated">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-gray-900">Book Orders Analytics</h2>
          <p class="mt-1 text-sm text-gray-600">Complete overview of book sales and orders</p>
        </div>
        <x-ui.link href="{{ route('admin.book-orders.index') }}" variant="outline" size="sm">
          View All
        </x-ui.link>
      </div>

      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
        <div class="rounded-lg border border-gray-200 bg-white p-4 text-center">
          <div class="text-2xl font-bold text-gray-900">{{ number_format($bookOrdersStats['total']) }}</div>
          <div class="mt-1 text-xs font-medium text-gray-500">Total Orders</div>
        </div>
        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-center">
          <div class="text-2xl font-bold text-yellow-700">{{ number_format($bookOrdersStats['pending']) }}</div>
          <div class="mt-1 text-xs font-medium text-yellow-600">Pending</div>
        </div>
        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-center">
          <div class="text-2xl font-bold text-blue-700">{{ number_format($bookOrdersStats['processing']) }}</div>
          <div class="mt-1 text-xs font-medium text-blue-600">Processing</div>
        </div>
        <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-4 text-center">
          <div class="text-2xl font-bold text-indigo-700">{{ number_format($bookOrdersStats['shipped']) }}</div>
          <div class="mt-1 text-xs font-medium text-indigo-600">Shipped</div>
        </div>
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-center">
          <div class="text-2xl font-bold text-green-700">{{ number_format($bookOrdersStats['delivered']) }}</div>
          <div class="mt-1 text-xs font-medium text-green-600">Delivered</div>
        </div>
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-center">
          <div class="text-2xl font-bold text-red-700">{{ number_format($bookOrdersStats['cancelled']) }}</div>
          <div class="mt-1 text-xs font-medium text-red-600">Cancelled</div>
        </div>
      </div>

      <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-lg border-l-4 border-primary-500 bg-primary-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-primary-600">This Month Revenue</p>
              <p class="mt-1 text-2xl font-bold text-primary-900">{{ format_price($bookOrdersStats['this_month_revenue']) }}</p>
              <p class="mt-1 text-xs text-primary-500">{{ number_format($bookOrdersStats['this_month_orders']) }} orders</p>
            </div>
            <div class="rounded-full bg-primary-100 p-3">
              <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>
        <div class="rounded-lg border-l-4 border-green-500 bg-green-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-green-600">Total Revenue</p>
              <p class="mt-1 text-2xl font-bold text-green-900">{{ format_price($bookOrdersStats['total_revenue']) }}</p>
              <p class="mt-1 text-xs text-green-500">All time</p>
            </div>
            <div class="rounded-full bg-green-100 p-3">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </x-card>

    <!-- Course Registrations Section -->
    <x-card variant="elevated">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-gray-900">Course Enrollments Analytics</h2>
          <p class="mt-1 text-sm text-gray-600">Online and offline enrollment statistics</p>
        </div>
        <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="outline" size="sm">
          View All
        </x-ui.link>
      </div>

      <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-6">
        <div class="rounded-lg border border-gray-200 bg-white p-4 text-center">
          <div class="text-2xl font-bold text-gray-900">{{ number_format($courseRegistrationsStats['total']) }}</div>
          <div class="mt-1 text-xs font-medium text-gray-500">Total</div>
        </div>
        <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 text-center">
          <div class="text-2xl font-bold text-blue-700">{{ number_format($courseRegistrationsStats['online']) }}</div>
          <div class="mt-1 text-xs font-medium text-blue-600">Online</div>
        </div>
        <div class="rounded-lg border border-purple-200 bg-purple-50 p-4 text-center">
          <div class="text-2xl font-bold text-purple-700">{{ number_format($courseRegistrationsStats['offline']) }}</div>
          <div class="mt-1 text-xs font-medium text-purple-600">Offline</div>
        </div>
        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-center">
          <div class="text-2xl font-bold text-yellow-700">{{ number_format($courseRegistrationsStats['pending']) }}</div>
          <div class="mt-1 text-xs font-medium text-yellow-600">Pending</div>
        </div>
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-center">
          <div class="text-2xl font-bold text-green-700">{{ number_format($courseRegistrationsStats['confirmed']) }}</div>
          <div class="mt-1 text-xs font-medium text-green-600">Confirmed</div>
        </div>
        <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-4 text-center">
          <div class="text-2xl font-bold text-indigo-700">{{ number_format($courseRegistrationsStats['completed']) }}</div>
          <div class="mt-1 text-xs font-medium text-indigo-600">Completed</div>
        </div>
      </div>

      <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-lg border-l-4 border-blue-500 bg-blue-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-blue-600">This Month Enrollments</p>
              <p class="mt-1 text-2xl font-bold text-blue-900">{{ number_format($courseRegistrationsStats['this_month_registrations']) }}</p>
              <p class="mt-1 text-xs text-blue-500">New enrollments</p>
            </div>
            <div class="rounded-full bg-blue-100 p-3">
              <x-icon name="enrollments" class="h-6 w-6 text-blue-600" />
            </div>
          </div>
        </div>
        <div class="rounded-lg border-l-4 border-purple-500 bg-purple-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-purple-600">Online vs Offline</p>
              <p class="mt-1 text-lg font-bold text-purple-900">
                {{ $courseRegistrationsStats['total'] > 0 ? number_format(($courseRegistrationsStats['online'] / $courseRegistrationsStats['total']) * 100, 1) : 0 }}% Online
              </p>
              <p class="mt-1 text-xs text-purple-500">
                {{ $courseRegistrationsStats['total'] > 0 ? number_format(($courseRegistrationsStats['offline'] / $courseRegistrationsStats['total']) * 100, 1) : 0 }}% Offline
              </p>
            </div>
            <div class="rounded-full bg-purple-100 p-3">
              <x-icon name="courses" class="h-6 w-6 text-purple-600" />
            </div>
          </div>
        </div>
      </div>
    </x-card>

    <!-- Installments Section -->
    <x-card variant="elevated">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-gray-900">Installments Analytics</h2>
          <p class="mt-1 text-sm text-gray-600">Payment tracking and collection statistics</p>
        </div>
        <x-ui.link href="{{ route('admin.course-registrations.installments') }}" variant="outline" size="sm">
          View All
        </x-ui.link>
      </div>

      <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
        <div class="rounded-lg border border-gray-200 bg-white p-4 text-center">
          <div class="text-2xl font-bold text-gray-900">{{ number_format($installmentsStats['total']) }}</div>
          <div class="mt-1 text-xs font-medium text-gray-500">Total</div>
        </div>
        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-center">
          <div class="text-2xl font-bold text-yellow-700">{{ number_format($installmentsStats['pending']) }}</div>
          <div class="mt-1 text-xs font-medium text-yellow-600">Pending</div>
          <div class="mt-1 text-xs text-yellow-500">{{ format_price($installmentsStats['pending_amount'], false) }}</div>
        </div>
        <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-center">
          <div class="text-2xl font-bold text-green-700">{{ number_format($installmentsStats['paid']) }}</div>
          <div class="mt-1 text-xs font-medium text-green-600">Paid</div>
          <div class="mt-1 text-xs text-green-500">{{ format_price($installmentsStats['paid_amount'], false) }}</div>
        </div>
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-center">
          <div class="text-2xl font-bold text-red-700">{{ number_format($installmentsStats['overdue']) }}</div>
          <div class="mt-1 text-xs font-medium text-red-600">Overdue</div>
          <div class="mt-1 text-xs text-red-500">{{ format_price($installmentsStats['overdue_amount'], false) }}</div>
        </div>
      </div>

      <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-lg border-l-4 border-yellow-500 bg-yellow-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-yellow-600">Due Today</p>
              <p class="mt-1 text-2xl font-bold text-yellow-900">{{ number_format($installmentsStats['due_today']) }}</p>
            </div>
            <div class="rounded-full bg-yellow-100 p-3">
              <x-icon name="calendar" class="h-6 w-6 text-yellow-600" />
            </div>
          </div>
        </div>
        <div class="rounded-lg border-l-4 border-green-500 bg-green-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-green-600">Collection Rate</p>
              <p class="mt-1 text-2xl font-bold text-green-900">
                {{ $installmentsStats['total_amount'] > 0 ? number_format(($installmentsStats['paid_amount'] / $installmentsStats['total_amount']) * 100, 1) : 0 }}%
              </p>
            </div>
            <div class="rounded-full bg-green-100 p-3">
              <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
          </div>
        </div>
        <div class="rounded-lg border-l-4 border-blue-500 bg-blue-50 p-4">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-blue-600">Total Amount</p>
              <p class="mt-1 text-2xl font-bold text-blue-900">{{ format_price($installmentsStats['total_amount'], false) }}</p>
            </div>
            <div class="rounded-full bg-blue-100 p-3">
              <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </x-card>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- Recent Book Orders -->
      <x-card variant="elevated" padding="lg">
        <div class="mb-6 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Book Orders</h3>
          <x-ui.link href="{{ route('admin.book-orders.index') }}" variant="outline" size="sm">
            View All
          </x-ui.link>
        </div>
        <div class="space-y-4">
          @forelse($recentBookOrders as $order)
            <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
              <div class="flex-shrink-0">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100">
                  <x-icon name="orders" class="h-6 w-6 text-primary-600" />
                </div>
              </div>
              <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-900">Order #{{ $order->id }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ $order->name }} - {{ $order->book->title ?? 'Unknown Book' }}</p>
                <p class="mt-1 text-xs font-medium text-primary-600">{{ format_price($order->total_amount) }}</p>
              </div>
              <div class="flex-shrink-0 text-right">
                <x-ui.badge :variant="$order->status === 'pending' ? 'warning' : ($order->status === 'delivered' ? 'success' : 'primary')" size="sm">
                  {{ ucfirst($order->status) }}
                </x-ui.badge>
                <p class="mt-1 text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
              </div>
            </div>
          @empty
            <p class="text-sm text-gray-500">No recent orders</p>
          @endforelse
        </div>
      </x-card>

      <!-- Recent Course Registrations -->
      <x-card variant="elevated" padding="lg">
        <div class="mb-6 flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Recent Enrollments</h3>
          <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="outline" size="sm">
            View All
          </x-ui.link>
        </div>
        <div class="space-y-4">
          @forelse($recentCourseRegistrations as $registration)
            <div class="flex items-start gap-4 border-b border-gray-100 pb-4 last:border-0 last:pb-0">
              <div class="flex-shrink-0">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent-100">
                  <x-icon name="enrollments" class="h-6 w-6 text-accent-600" />
                </div>
              </div>
              <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ $registration->name }}</p>
                <p class="mt-1 text-xs text-gray-500">{{ $registration->course->title ?? 'Unknown Course' }}</p>
                <p class="mt-1 text-xs font-medium text-accent-600">
                  {{ ucfirst($registration->enrollment_type) }} Enrollment
                </p>
              </div>
              <div class="flex-shrink-0 text-right">
                <x-ui.badge :variant="$registration->status === 'pending' ? 'warning' : ($registration->status === 'confirmed' ? 'success' : 'primary')" size="sm">
                  {{ ucfirst($registration->status) }}
                </x-ui.badge>
                <p class="mt-1 text-xs text-gray-500">{{ $registration->created_at->diffForHumans() }}</p>
              </div>
            </div>
          @empty
            <p class="text-sm text-gray-500">No recent enrollments</p>
          @endforelse
        </div>
      </x-card>
    </div>

    <!-- Urgent Installments -->
    @if($recentInstallments->count() > 0)
      <x-card variant="elevated" padding="lg">
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Urgent Installments</h3>
            <p class="mt-1 text-sm text-gray-600">Overdue and due today installments</p>
          </div>
          <x-ui.link href="{{ route('admin.course-registrations.installments') }}" variant="outline" size="sm">
            View All
          </x-ui.link>
        </div>
        <div class="space-y-4">
          @foreach($recentInstallments as $installment)
            @php
              $isOverdue = $installment->due_date < now()->startOfDay();
              $isDueToday = $installment->due_date->isToday();
            @endphp
            <div class="flex items-start gap-4 rounded-lg border {{ $isOverdue ? 'border-red-200 bg-red-50' : 'border-yellow-200 bg-yellow-50' }} p-4">
              <div class="flex-shrink-0">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $isOverdue ? 'bg-red-100' : 'bg-yellow-100' }}">
                  <x-icon name="calendar" class="h-6 w-6 {{ $isOverdue ? 'text-red-600' : 'text-yellow-600' }}" />
                </div>
              </div>
              <div class="min-w-0 flex-1">
                <p class="text-sm font-semibold text-gray-900">
                  {{ $installment->courseRegistration->name ?? 'Unknown' }}
                </p>
                <p class="mt-1 text-xs text-gray-500">
                  {{ $installment->courseRegistration->course->title ?? 'Unknown Course' }}
                </p>
                <p class="mt-1 text-xs font-medium {{ $isOverdue ? 'text-red-600' : 'text-yellow-600' }}">
                  Installment #{{ $installment->installment_number }} - {{ format_price($installment->amount) }}
                </p>
              </div>
              <div class="flex-shrink-0 text-right">
                <x-ui.badge :variant="$isOverdue ? 'danger' : 'warning'" size="sm">
                  {{ $isOverdue ? 'Overdue' : 'Due Today' }}
                </x-ui.badge>
                <p class="mt-1 text-xs text-gray-500">{{ $installment->due_date->format('M d, Y') }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </x-card>
    @endif

    <!-- Quick Actions -->
    <x-card variant="elevated" padding="lg">
      <h3 class="mb-6 text-lg font-semibold text-gray-900">Quick Actions</h3>
      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
        <a href="{{ route('admin.book-orders.index') }}"
           class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-primary-200 hover:bg-primary-50 hover:shadow-sm">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-100 transition-colors group-hover:bg-primary-200">
              <x-icon name="orders" class="h-6 w-6 text-primary-600" />
            </div>
            <span class="text-sm font-semibold text-gray-900">Book Orders</span>
          </div>
          <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-primary-600" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        <a href="{{ route('admin.course-registrations.index') }}"
           class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-secondary-200 hover:bg-secondary-50 hover:shadow-sm">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-secondary-100 transition-colors group-hover:bg-secondary-200">
              <x-icon name="enrollments" class="h-6 w-6 text-secondary-600" />
            </div>
            <span class="text-sm font-semibold text-gray-900">Enrollments</span>
          </div>
          <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-secondary-600" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        <a href="{{ route('admin.course-registrations.installments') }}"
           class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-accent-200 hover:bg-accent-50 hover:shadow-sm">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-accent-100 transition-colors group-hover:bg-accent-200">
              <x-icon name="calendar" class="h-6 w-6 text-accent-600" />
            </div>
            <span class="text-sm font-semibold text-gray-900">Installments</span>
          </div>
          <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-accent-600" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        <a href="{{ route('admin.settings.index') }}"
           class="group flex items-center justify-between rounded-xl border border-gray-200 bg-white p-4 transition-all hover:border-light-200 hover:bg-light-50 hover:shadow-sm">
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-light-100 transition-colors group-hover:bg-light-200">
              <x-icon name="cog" class="h-6 w-6 text-light-600" />
            </div>
            <span class="text-sm font-semibold text-gray-900">Settings</span>
          </div>
          <svg class="h-5 w-5 text-gray-400 transition-colors group-hover:text-light-600" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </x-card>
  </div>
@endsection
