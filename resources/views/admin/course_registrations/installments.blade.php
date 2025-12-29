@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Installment Payments</h1>
        <p class="mt-1 text-sm text-gray-600">Manage and track all course installment payments</p>
      </div>
      <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="default" size="md">
        ← Back to Enrollments
      </x-ui.link>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <!-- Total Pending -->
      <x-card variant="elevated" class="border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Pending Payments</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($analytics['pending_count']) }}</p>
            <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['pending_amount'], 2) }}</p>
          </div>
          <div class="rounded-full bg-yellow-100 p-3">
            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </x-card>

      <!-- Overdue -->
      <x-card variant="elevated" class="border-l-4 border-red-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Overdue</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($analytics['overdue_count']) }}</p>
            <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['overdue_amount'], 2) }}</p>
          </div>
          <div class="rounded-full bg-red-100 p-3">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
        </div>
      </x-card>

      <!-- Due Today -->
      <x-card variant="elevated" class="border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Due Today</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($analytics['due_today_count']) }}</p>
            <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['due_today_amount'], 2) }}</p>
          </div>
          <div class="rounded-full bg-orange-100 p-3">
            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
      </x-card>

      <!-- Due Next 7 Days -->
      <x-card variant="elevated" class="border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Next 7 Days</p>
            <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($analytics['due_next_7_days_count']) }}</p>
            <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['due_next_7_days_amount'], 2) }}</p>
          </div>
          <div class="rounded-full bg-blue-100 p-3">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
        </div>
      </x-card>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
      <x-card variant="elevated">
        <div class="text-center">
          <p class="text-sm font-medium text-gray-600">Total Paid</p>
          <p class="mt-1 text-2xl font-bold text-green-600">{{ number_format($analytics['paid_count']) }} installments</p>
          <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['paid_amount'], 2) }}</p>
        </div>
      </x-card>
      <x-card variant="elevated">
        <div class="text-center">
          <p class="text-sm font-medium text-gray-600">Total Amount</p>
          <p class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($analytics['total_installments']) }}
            installments</p>
          <p class="mt-1 text-sm text-gray-500">BDT {{ number_format($analytics['total_amount'], 2) }}</p>
        </div>
      </x-card>
      <x-card variant="elevated">
        <div class="text-center">
          <p class="text-sm font-medium text-gray-600">Collection Rate</p>
          <p class="mt-1 text-2xl font-bold text-primary-600">
            {{ $analytics['total_amount'] > 0 ? number_format(($analytics['paid_amount'] / $analytics['total_amount']) * 100, 1) : 0 }}%
          </p>
          <p class="mt-1 text-sm text-gray-500">{{ number_format($analytics['paid_count']) }} of
            {{ number_format($analytics['total_installments']) }} paid</p>
        </div>
      </x-card>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated" x-data="{ filtersOpen: {{ request()->anyFilled(['search', 'status', 'course_id', 'due_date_filter', 'due_date_from', 'due_date_to']) ? 'true' : 'false' }} }">
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
            @if (request()->anyFilled(['search', 'status', 'course_id', 'due_date_filter', 'due_date_from', 'due_date_to']))
              <x-ui.badge variant="primary"
                          size="sm">{{ collect(['search', 'status', 'course_id', 'due_date_filter', 'due_date_from', 'due_date_to'])->filter(fn($key) => request()->filled($key))->count() }}</x-ui.badge>
            @endif
          </button>
        </div>
        @if (request()->anyFilled(['search', 'status', 'course_id', 'due_date_filter', 'due_date_from', 'due_date_to']))
          <a href="{{ route('admin.course-registrations.installments') }}"
             class="text-sm text-gray-600 hover:text-gray-900">
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
        <form method="GET" action="{{ route('admin.course-registrations.installments') }}" id="filter-form"
              class="space-y-6 pt-6">
          <!-- Search Bar -->
          <div>
            <x-ui.search name="search" placeholder="Search by student name, email, phone, course name..."
                         value="{{ request('search') }}" />
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Status Filter -->
            <div>
              <x-forms.select name="status" label="Status" id="filter-status" :options="[
                  '' => 'All Statuses',
                  'pending' => 'Pending',
                  'paid' => 'Paid',
                  'overdue' => 'Overdue',
              ]" :value="request('status')"
                              placeholder="" />
            </div>

            <!-- Course Filter -->
            <div>
              <x-forms.select name="course_id" label="Course" id="filter-course-id" :options="['' => 'All Courses'] + $courses->toArray()" :value="request('course_id')"
                              placeholder="" />
            </div>

            <!-- Due Date Quick Filter -->
            <div>
              <x-forms.select name="due_date_filter" label="Due Date" id="filter-due-date" :options="[
                  '' => 'All Dates',
                  'overdue' => 'Overdue',
                  'today' => 'Due Today',
                  'next_7_days' => 'Next 7 Days',
                  'next_30_days' => 'Next 30 Days',
              ]"
                              :value="request('due_date_filter')" placeholder="" />
            </div>

            <!-- Date Range -->
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">Date Range</label>
              <div class="grid grid-cols-2 gap-2">
                <input type="date" name="due_date_from" id="due_date_from" value="{{ request('due_date_from') }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                <input type="date" name="due_date_to" id="due_date_to" value="{{ request('due_date_to') }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
              </div>
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
            $(this).find('select, input[type="date"]').each(function() {
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

    <!-- Installments Table -->
    @if ($installments->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Student</x-ui.table-cell>
              <x-ui.table-cell header>Course</x-ui.table-cell>
              <x-ui.table-cell header>Installment</x-ui.table-cell>
              <x-ui.table-cell header>Amount</x-ui.table-cell>
              <x-ui.table-cell header>Due Date</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header>Paid Date</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($installments as $installment)
              @php
                $registration = $installment->courseRegistration;
                $isOverdue = $installment->status === 'pending' && $installment->due_date < now()->startOfDay();
                $isDueToday = $installment->status === 'pending' && $installment->due_date->isToday();
                $isUpcoming = $installment->status === 'pending' && $installment->due_date > now()->startOfDay();
              @endphp
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ $registration->name }}</div>
                    <div class="text-xs text-gray-500">{{ $registration->email }}</div>
                    <div class="text-xs text-gray-400">{{ $registration->phone }}</div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div>
                    <div class="text-sm text-gray-900">{{ $registration->course->title ?? 'Unknown Course' }}</div>
                    @if ($registration->courseVariation)
                      <div class="text-xs text-gray-500">{{ $registration->courseVariation->name }}</div>
                    @endif
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <span
                        class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                    #{{ $installment->installment_number }}
                  </span>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">BDT {{ number_format($installment->amount, 2) }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="flex flex-col gap-1">
                    <div class="text-sm text-gray-900">{{ $installment->due_date->format('M d, Y') }}</div>
                    @if ($isOverdue)
                      <x-ui.badge variant="danger" size="sm">Overdue</x-ui.badge>
                    @elseif($isDueToday)
                      <x-ui.badge variant="warning" size="sm">Due Today</x-ui.badge>
                    @elseif($isUpcoming)
                      <span class="text-xs text-gray-500">{{ $installment->due_date->diffForHumans() }}</span>
                    @endif
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($installment->status === 'paid')
                    <x-ui.badge variant="success" size="sm">Paid</x-ui.badge>
                  @elseif($isOverdue)
                    <x-ui.badge variant="danger" size="sm">Overdue</x-ui.badge>
                  @else
                    <x-ui.badge variant="warning" size="sm">Pending</x-ui.badge>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($installment->paid_date)
                    <div class="text-sm text-gray-600">{{ $installment->paid_date->format('M d, Y') }}</div>
                  @else
                    <span class="text-sm text-gray-400">-</span>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.course-registrations.show', $registration) }}" variant="outline"
                               size="sm">
                      View
                    </x-ui.link>
                    @if ($installment->status === 'pending')
                      <button type="button"
                              onclick="openMarkPaidModal({{ $installment->id }}, '{{ $installment->amount }}', '{{ $installment->due_date->format('Y-m-d') }}', {{ $registration->id }})"
                              class="inline-flex items-center rounded-md border border-green-300 bg-white px-2.5 py-1.5 text-xs font-medium text-green-700 shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Mark Paid
                      </button>
                    @endif
                  </div>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$installments" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No installments found"
                          description="{{ request()->anyFilled(['search', 'status', 'course_id', 'due_date_filter', 'due_date_from', 'due_date_to']) ? 'Try adjusting your filters to see more results.' : 'No installment payments have been created yet.' }}"
                          icon="calendar" />
      </x-card>
    @endif

    <!-- Mark Paid Modal -->
    <div id="markPaidModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
         role="dialog" aria-modal="true">
      <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeMarkPaidModal()"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>
        <div
             class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
          <form id="markPaidForm" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div
                     class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="mt-3 w-full text-center sm:ml-4 sm:mt-0 sm:text-left">
                  <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                    Mark Installment as Paid
                  </h3>
                  <div class="mt-4 space-y-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Amount</label>
                      <input type="text" id="modalAmount" readonly
                             class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Due Date</label>
                      <input type="text" id="modalDueDate" readonly
                             class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm sm:text-sm">
                    </div>
                    <div>
                      <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                      <input type="text" name="payment_method" id="payment_method"
                             class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>
                    <div>
                      <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                      <input type="text" name="transaction_id" id="transaction_id"
                             class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                    </div>
                    <div>
                      <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                      <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
              <button type="submit"
                      class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
                Mark as Paid
              </button>
              <button type="button" onclick="closeMarkPaidModal()"
                      class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @push('scripts')
      <script>
        function openMarkPaidModal(installmentId, amount, dueDate, registrationId) {
          const modal = document.getElementById('markPaidModal');
          const form = document.getElementById('markPaidForm');

          form.action = `/admin/course-registrations/${registrationId}/installments/${installmentId}`;
          document.getElementById('modalAmount').value = 'BDT ' + parseFloat(amount).toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
          document.getElementById('modalDueDate').value = new Date(dueDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
          });

          modal.classList.remove('hidden');
        }

        function closeMarkPaidModal() {
          document.getElementById('markPaidModal').classList.add('hidden');
          document.getElementById('markPaidForm').reset();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape') {
            closeMarkPaidModal();
          }
        });
      </script>
    @endpush
  </div>
@endsection
