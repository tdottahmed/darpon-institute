@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Course Enrollments</h1>
        <p class="mt-1 text-sm text-gray-600">Manage all course enrollments and registrations</p>
      </div>
      <x-ui.link href="{{ route('admin.course-registrations.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create Offline Enrollment
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated" x-data="{ filtersOpen: {{ request()->anyFilled(['search', 'status', 'enrollment_type', 'course_id', 'payment_status', 'is_installment']) ? 'true' : 'false' }} }">
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
              $activeFiltersCount = collect([
                  request('search'),
                  request('status'),
                  request('enrollment_type'),
                  request('course_id'),
                  request('payment_status'),
                  request('is_installment'),
              ])
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
        @if (request()->anyFilled(['search', 'status', 'enrollment_type', 'course_id', 'payment_status', 'is_installment']))
          <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="outline" size="sm">
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
        <form method="GET" action="{{ route('admin.course-registrations.index') }}" id="filter-form"
              class="space-y-6 pt-6">
          <!-- Search Bar - Full Width -->
          <div>
            <x-ui.search name="search" placeholder="Search by name, email, phone, course name..."
                         value="{{ request('search') }}" />
          </div>

          <!-- Filter Grid -->
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Status Filter -->
            <div>
              <x-forms.select name="status" label="Status" id="filter-status" :options="[
                  '' => 'All Statuses',
                  'pending' => 'Pending',
                  'confirmed' => 'Confirmed',
                  'completed' => 'Completed',
                  'cancelled' => 'Cancelled',
              ]" :value="request('status')"
                              placeholder="" />
            </div>

            <!-- Enrollment Type Filter -->
            <div>
              <x-forms.select name="enrollment_type" label="Enrollment Type" id="filter-enrollment-type" :options="['' => 'All Types', 'online' => 'Online', 'offline' => 'Offline']"
                              :value="request('enrollment_type')" placeholder="" />
            </div>

            <!-- Course Filter -->
            <div>
              <x-forms.select name="course_id" label="Course" id="filter-course-id" :options="['' => 'All Courses'] + $courses->toArray()" :value="request('course_id')"
                              placeholder="" />
            </div>

            <!-- Payment Status Filter -->
            <div>
              <x-forms.select name="payment_status" label="Payment Status" id="filter-payment-status" :options="[
                  '' => 'All Payment Statuses',
                  'pending' => 'Pending',
                  'verified' => 'Verified',
                  'rejected' => 'Rejected',
              ]"
                              :value="request('payment_status')" placeholder="" />
            </div>

            <!-- Installment Filter -->
            <div>
              <x-forms.select name="is_installment" label="Payment Type" id="filter-is-installment" :options="['' => 'All Payment Types', '1' => 'Installment', '0' => 'One-time']"
                              :value="request('is_installment')" placeholder="" />
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

    <!-- Enrollments Table -->
    @if ($registrations->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>ID</x-ui.table-cell>
              <x-ui.table-cell header>Student</x-ui.table-cell>
              <x-ui.table-cell header>Course</x-ui.table-cell>
              <x-ui.table-cell header>Type</x-ui.table-cell>
              <x-ui.table-cell header>Contact</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header>Date</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($registrations as $registration)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">#{{ $registration->id }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm font-medium text-gray-900">{{ $registration->name }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $registration->course->title ?? 'Unknown Course' }}</div>
                  @if ($registration->courseVariation)
                    <div class="text-xs text-gray-500">{{ $registration->courseVariation->name }}</div>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="flex flex-col gap-1">
                    <x-ui.badge :variant="$registration->enrollment_type === 'offline' ? 'secondary' : 'primary'" size="sm">
                      {{ ucfirst($registration->enrollment_type) }}
                    </x-ui.badge>
                    @if ($registration->is_installment_payment)
                      <span class="text-xs text-gray-500">Installment</span>
                    @endif
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $registration->email }}</div>
                  <div class="text-xs text-gray-500">{{ $registration->phone }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @php
                    $statusVariants = [
                        'pending' => 'warning',
                        'confirmed' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ];
                    $variant = $statusVariants[$registration->status] ?? 'secondary';
                  @endphp
                  <x-ui.badge :variant="$variant" size="sm">
                    {{ ucfirst($registration->status) }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $registration->created_at->format('M d, Y') }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <x-ui.link href="{{ route('admin.course-registrations.show', $registration) }}" variant="outline"
                             size="sm">
                    View
                  </x-ui.link>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$registrations" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No enrollments found"
                          description="{{ request()->anyFilled(['search', 'status', 'enrollment_type', 'course_id', 'payment_status', 'is_installment']) ? 'Try adjusting your filters to see more results.' : 'No students have enrolled in courses yet.' }}"
                          icon="academic-cap">
          @if (!request()->anyFilled(['search', 'status', 'enrollment_type', 'course_id', 'payment_status', 'is_installment']))
            <x-ui.link href="{{ route('admin.course-registrations.create') }}" variant="primary" size="md">
              Create Offline Enrollment
            </x-ui.link>
          @endif
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
