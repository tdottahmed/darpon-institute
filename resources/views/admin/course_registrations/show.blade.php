@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Enrollment #{{ $courseRegistration->id }}</h1>
        <p class="mt-1 text-sm text-gray-600">
          Registered on {{ $courseRegistration->created_at->format('F d, Y h:i A') }}
        </p>
      </div>
      <div class="flex gap-2">
        <a href="{{ route('admin.course-registrations.invoice', $courseRegistration) }}" target="_blank"
           class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
          </svg>
          Print Invoice
        </a>
        <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="default" size="md">
          ← Back to List
        </x-ui.link>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- Main Content -->
      <div class="space-y-6 lg:col-span-2">
        <!-- Course Details -->
        <x-card variant="elevated">
          <div class="flex items-center space-x-4">
            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100">
              @if ($courseRegistration->course->thumbnail)
                <img src="{{ Storage::url($courseRegistration->course->thumbnail) }}" alt=""
                     class="h-full w-full object-cover">
              @else
                <div class="flex h-full w-full items-center justify-center text-xs text-gray-400">No Image</div>
              @endif
            </div>
            <div class="min-w-0 flex-1">
              <h3 class="text-lg font-bold text-gray-900">{{ $courseRegistration->course->title }}</h3>
              <p class="mt-1 text-sm text-gray-500">
                @if ($courseRegistration->courseVariation)
                  {{ $courseRegistration->courseVariation->name }}
                  @if ($courseRegistration->courseVariation->duration)
                    • {{ $courseRegistration->courseVariation->duration }}
                  @endif
                @else
                  {{ $courseRegistration->course->duration ?? 'N/A' }}
                @endif
              </p>
              @php
                $totalPrice = 0;
                if ($courseRegistration->courseVariation) {
                    $totalPrice = $courseRegistration->courseVariation->discounted_price;
                } elseif ($courseRegistration->course) {
                    $totalPrice =
                        $courseRegistration->course->discounted_price ?? ($courseRegistration->course->price ?? 0);
                }
              @endphp
              <p class="mt-2 text-lg font-semibold text-primary-600">
                BDT {{ number_format($totalPrice, 2) }}
              </p>
            </div>
          </div>
        </x-card>

        <!-- Student Information -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Student Information</h3>
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Full Name</dt>
              <dd class="mt-1 text-sm font-medium text-gray-900">{{ $courseRegistration->name }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Email Address</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $courseRegistration->email }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ $courseRegistration->phone }}</dd>
            </div>
            <div class="sm:col-span-2">
              <dt class="text-sm font-medium text-gray-500">Address</dt>
              <dd class="mt-1 whitespace-pre-wrap text-sm text-gray-900">{{ $courseRegistration->address ?? 'N/A' }}</dd>
            </div>
          </dl>
        </x-card>

        <!-- Enrollment Details -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Enrollment Details</h3>
          <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500">Enrollment Type</dt>
              <dd class="mt-1">
                <x-ui.badge :variant="$courseRegistration->enrollment_type === 'offline' ? 'secondary' : 'primary'" size="sm">
                  {{ ucfirst($courseRegistration->enrollment_type) }}
                </x-ui.badge>
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Payment Type</dt>
              <dd class="mt-1">
                @if ($courseRegistration->is_installment_payment)
                  <x-ui.badge variant="info" size="sm">Installment Payment</x-ui.badge>
                @else
                  <x-ui.badge variant="gray" size="sm">One-time Payment</x-ui.badge>
                @endif
              </dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500">Enrollment Status</dt>
              <dd class="mt-1">
                @php
                  $statusVariants = [
                      'pending' => 'warning',
                      'confirmed' => 'primary',
                      'completed' => 'success',
                      'cancelled' => 'danger',
                  ];
                  $variant = $statusVariants[$courseRegistration->status] ?? 'secondary';
                @endphp
                <x-ui.badge :variant="$variant" size="sm">
                  {{ ucfirst($courseRegistration->status) }}
                </x-ui.badge>
              </dd>
            </div>
            @if ($courseRegistration->payment_gateway_id)
              <div>
                <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                <dd class="mt-1">
                  @php
                    $paymentStatusVariants = [
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                    ];
                    $paymentVariant = $paymentStatusVariants[$courseRegistration->payment_status] ?? 'secondary';
                  @endphp
                  <x-ui.badge :variant="$paymentVariant" size="sm">
                    {{ ucfirst($courseRegistration->payment_status) }}
                  </x-ui.badge>
                </dd>
              </div>
            @endif
          </dl>
        </x-card>

        <!-- Installment Schedule -->
        @if ($courseRegistration->is_installment_payment && $courseRegistration->installments->count() > 0)
          <x-card variant="elevated">
            <div class="mb-4 flex items-center justify-between">
              <h3 class="text-lg font-semibold text-gray-900">Installment Schedule</h3>
              <button type="button" onclick="openInstallmentModal()"
                      class="text-sm font-medium text-primary-600 hover:text-primary-700">
                Manage Installments
              </button>
            </div>
            <x-ui.table>
              <x-ui.table-head>
                <x-ui.table-row>
                  <x-ui.table-cell header>#</x-ui.table-cell>
                  <x-ui.table-cell header>Amount</x-ui.table-cell>
                  <x-ui.table-cell header>Due Date</x-ui.table-cell>
                  <x-ui.table-cell header>Status</x-ui.table-cell>
                  <x-ui.table-cell header>Paid Date</x-ui.table-cell>
                  <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
                </x-ui.table-row>
              </x-ui.table-head>
              <x-ui.table-body>
                @foreach ($courseRegistration->installments as $installment)
                  <x-ui.table-row>
                    <x-ui.table-cell>{{ $installment->installment_number }}</x-ui.table-cell>
                    <x-ui.table-cell class="font-medium">BDT
                      {{ number_format($installment->amount, 2) }}</x-ui.table-cell>
                    <x-ui.table-cell>{{ $installment->due_date->format('M d, Y') }}</x-ui.table-cell>
                    <x-ui.table-cell>
                      @php
                        $installmentStatusVariants = [
                            'pending' => 'warning',
                            'paid' => 'success',
                            'overdue' => 'danger',
                        ];
                        $installmentVariant = $installmentStatusVariants[$installment->status] ?? 'secondary';
                      @endphp
                      <x-ui.badge :variant="$installmentVariant" size="sm">
                        {{ ucfirst($installment->status) }}
                      </x-ui.badge>
                    </x-ui.table-cell>
                    <x-ui.table-cell>
                      {{ $installment->paid_date ? $installment->paid_date->format('M d, Y') : '-' }}
                    </x-ui.table-cell>
                    <x-ui.table-cell class="text-right">
                      <button type="button" onclick="openInstallmentModal({{ $installment->id }})"
                              class="text-sm font-medium text-primary-600 hover:text-primary-700">
                        Manage
                      </button>
                    </x-ui.table-cell>
                  </x-ui.table-row>
                @endforeach
              </x-ui.table-body>
            </x-ui.table>
          </x-card>
        @endif

        <!-- Payment Information -->
        @if ($courseRegistration->payment_gateway_id)
          <x-card variant="elevated">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Payment Information</h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ $courseRegistration->paymentGateway->name ?? 'N/A' }}
                  <span class="ml-2 text-xs text-gray-500">
                    ({{ ucfirst($courseRegistration->paymentGateway->type ?? '') }})
                  </span>
                </dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Transaction ID</dt>
                <dd class="mt-1 font-mono text-sm text-gray-900">{{ $courseRegistration->transaction_id ?? 'N/A' }}</dd>
              </div>
              @if ($courseRegistration->payment_screenshot)
                <div class="sm:col-span-2">
                  <dt class="text-sm font-medium text-gray-500">Payment Screenshot</dt>
                  <dd class="mt-1">
                    <a href="{{ Storage::url($courseRegistration->payment_screenshot) }}" target="_blank"
                       class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700">
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
          </x-card>
        @endif
      </div>

      <!-- Sidebar Actions -->
      <div class="space-y-6 lg:col-span-1">
        <!-- Status Management -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-gray-900">Update Status</h3>
          <form action="{{ route('admin.course-registrations.update', $courseRegistration) }}" method="POST"
                class="space-y-4">
            @csrf
            @method('PUT')
            <div>
              <x-forms.select name="status" label="Enrollment Status" :options="[
                  'pending' => 'Pending',
                  'confirmed' => 'Confirmed',
                  'completed' => 'Completed',
                  'cancelled' => 'Cancelled',
              ]" :value="$courseRegistration->status" />
            </div>
            @if ($courseRegistration->payment_gateway_id)
              <div>
                <x-forms.select name="payment_status" label="Payment Status" :options="[
                    'pending' => 'Pending',
                    'verified' => 'Verified',
                    'rejected' => 'Rejected',
                ]" :value="$courseRegistration->payment_status" />
              </div>
            @endif
            <x-button type="submit" variant="primary" size="md" class="w-full">
              Update Status
            </x-button>
          </form>
        </x-card>

        <!-- Danger Zone -->
        <x-card variant="elevated">
          <h3 class="mb-4 text-lg font-semibold text-red-600">Danger Zone</h3>
          <form action="{{ route('admin.course-registrations.destroy', $courseRegistration) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this enrollment? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="danger" size="md" class="w-full">
              Delete Enrollment
            </x-button>
          </form>
        </x-card>
      </div>
    </div>

    <!-- Installment Management Modal -->
    @if ($courseRegistration->is_installment_payment && $courseRegistration->installments->count() > 0)
      <div id="installment-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
           role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pb-20 pt-4 text-center sm:block sm:p-0">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
               onclick="closeInstallmentModal()"></div>
          <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
          <div
               class="inline-block transform overflow-hidden rounded-lg bg-white text-left align-bottom shadow-xl transition-all dark:bg-gray-800 sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="installment-form" method="POST">
              @csrf
              <div class="bg-white px-4 pb-4 pt-5 dark:bg-gray-800 sm:p-6 sm:pb-4">
                <h3 class="mb-4 text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">Manage
                  Installment</h3>
                <div class="space-y-4">
                  <div>
                    <x-forms.select name="status" label="Status *" :options="[
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                    ]" value="pending" required />
                  </div>
                  <div>
                    <x-forms.input name="paid_date" label="Paid Date" type="date" />
                  </div>
                  <div>
                    <x-forms.input name="payment_method" label="Payment Method"
                                   placeholder="e.g., Cash, Bank Transfer" />
                  </div>
                  <div>
                    <x-forms.input name="transaction_id" label="Transaction ID" placeholder="Transaction reference" />
                  </div>
                  <div>
                    <x-forms.textarea name="notes" label="Notes" rows="3" />
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 dark:bg-gray-700 sm:flex sm:flex-row-reverse sm:px-6">
                <x-button type="submit" variant="primary" size="md">
                  Update Installment
                </x-button>
                <button type="button" onclick="closeInstallmentModal()"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm">
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      @push('scripts')
        <script>
          const installments = @json($courseRegistration->installments->keyBy('id'));

          function openInstallmentModal(installmentId) {
            if (!installmentId) {
              // If no ID provided, just show the modal (for "Manage Installments" button)
              document.getElementById('installment-modal').classList.remove('hidden');
              return;
            }

            const installment = installments[installmentId];
            if (!installment) return;

            const form = document.getElementById('installment-form');
            form.action =
              '{{ route('admin.course-registrations.installments.update', [$courseRegistration, ':installment']) }}'.replace(
                ':installment', installmentId);

            document.querySelector('select[name="status"]').value = installment.status;
            document.querySelector('input[name="paid_date"]').value = installment.paid_date || '';
            document.querySelector('input[name="payment_method"]').value = installment.payment_method || '';
            document.querySelector('input[name="transaction_id"]').value = installment.transaction_id || '';
            document.querySelector('textarea[name="notes"]').value = installment.notes || '';

            document.getElementById('installment-modal').classList.remove('hidden');
          }

          function closeInstallmentModal() {
            document.getElementById('installment-modal').classList.add('hidden');
          }

          // Close modal on escape key
          document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
              closeInstallmentModal();
            }
          });
        </script>
      @endpush
    @endif
  </div>
@endsection
