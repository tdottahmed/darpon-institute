@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Offline Enrollment</h1>
        <p class="mt-1 text-sm text-gray-600">Manually enroll a student in a course</p>
      </div>
      <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="default">
        ← Back to Enrollments
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.course-registrations.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Course Selection -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
            <x-forms.select name="course_id" label="Course *" :options="$courses" :value="old('course_id')" required
                            :error="$errors->first('course_id')" placeholder="Select a course" id="course-select" />
            <p id="course-price-display" class="mt-1 hidden text-sm text-gray-500">
              <span class="font-semibold text-green-600"></span>
            </p>
          </div>
          <div>
            <x-forms.select name="course_variation_id" label="Course Variation" :value="old('course_variation_id')" :error="$errors->first('course_variation_id')"
                            placeholder="Select a variation (optional)" id="variation-select" />
            <p class="mt-1 text-xs text-gray-500">Leave empty if course has no variations</p>
          </div>
        </div>

        <!-- Student Information -->
        <div class="space-y-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
          <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Student Information</label>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <x-forms.input name="name" label="Full Name *" :value="old('name')" required :error="$errors->first('name')" />
            <x-forms.input name="email" label="Email Address *" type="email" :value="old('email')" required
                           :error="$errors->first('email')" />
            <x-forms.input name="phone" label="Phone Number *" :value="old('phone')" required :error="$errors->first('phone')" />
            <x-forms.select name="status" label="Enrollment Status *" :options="[
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ]" :value="old('status', 'confirmed')" required
                            :error="$errors->first('status')" />
          </div>
          <div>
            <x-forms.textarea name="address" label="Address" :value="old('address')" rows="3" :error="$errors->first('address')" />
          </div>
        </div>

        <!-- Payment Options -->
        <div class="space-y-4 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
          <div class="flex items-center space-x-3">
            <input type="hidden" name="is_installment_payment" value="0">
            <input type="checkbox" name="is_installment_payment" id="is_installment_payment" value="1"
                   {{ old('is_installment_payment') ? 'checked' : '' }} onchange="toggleInstallments()"
                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
            <label for="is_installment_payment" class="text-sm font-medium text-gray-700">Payment by Installments</label>
          </div>

          <!-- Installments Section -->
          <div id="installments-section" class="hidden space-y-4">
            <div class="flex items-center justify-between">
              <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Installment Schedule</label>
              <button type="button" id="add-installment-btn"
                      class="inline-flex items-center gap-2 rounded-md bg-primary-600 px-3 py-1.5 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Installment
              </button>
            </div>
            <div id="installments-container" class="space-y-4">
              <!-- Installments will be added here dynamically -->
            </div>
          </div>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.course-registrations.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Create Enrollment
          </x-button>
        </div>
      </form>
    </x-card>
  </div>


  @push('scripts')
    <script>
      $(document).ready(function() {
        let installmentCounter = 0;
        let currentTotalPrice = 0;
        const courses = @json($coursesData);

        // Load variations when course is selected
        $('#course-select').on('change', function() {
          const courseId = $(this).val();
          console.log(courseId);
          const $variationSelect = $('#variation-select');
          $variationSelect.html('<option value="">Select a variation (optional)</option>');
          $('#course-price-display').addClass('hidden');

          if (courseId && courses[courseId]) {
            const course = courses[courseId];

            // Show course base price
            if (course.price > 0) {
              $('#course-price-display').find('span').text('BDT ' + parseFloat(course.price).toFixed(2));
              $('#course-price-display').removeClass('hidden');
              currentTotalPrice = parseFloat(course.price);
            }

            if (course.active_variations && Array.isArray(course.active_variations) && course.active_variations
              .length > 0) {
              course.active_variations.forEach(function(variation) {
                const price = parseFloat(variation.discounted_price || variation.price);
                const option = $('<option></option>')
                  .attr('value', variation.id)
                  .attr('data-price', price)
                  .text(variation.name + ' - BDT ' + price.toFixed(2));
                $variationSelect.append(option);
              });
            } else {
              $variationSelect.append('<option value="" disabled>No variations available</option>');
            }

            updatePriceDisplay();
          }
        });

        // Update price when variation is selected
        $('#variation-select').on('change', function() {
          updatePriceDisplay();
        });

        function updatePriceDisplay() {
          const courseId = $('#course-select').val();
          const variationId = $('#variation-select').val();

          if (variationId && courses[courseId]) {
            const course = courses[courseId];
            if (course.active_variations && Array.isArray(course.active_variations)) {
              const variation = course.active_variations.find(function(v) {
                return String(v.id) === String(variationId);
              });
              if (variation) {
                currentTotalPrice = parseFloat(variation.discounted_price || variation.price);
                $('#course-price-display').find('span').text('BDT ' + currentTotalPrice.toFixed(2));
                $('#course-price-display').removeClass('hidden');
              }
            }
          } else if (courseId && courses[courseId] && courses[courseId].price > 0) {
            currentTotalPrice = parseFloat(courses[courseId].price);
            $('#course-price-display').find('span').text('BDT ' + currentTotalPrice.toFixed(2));
            $('#course-price-display').removeClass('hidden');
          }

          updateInstallmentSummary();
        }

        function toggleInstallments() {
          const isChecked = $('#is_installment_payment').is(':checked');
          const $section = $('#installments-section');

          if (isChecked) {
            $section.removeClass('hidden');
            if (installmentCounter === 0) {
              addInstallment();
            }
          } else {
            $section.addClass('hidden');
            $('#installments-container').empty();
            installmentCounter = 0;
            updateInstallmentSummary();
          }
        }

        $('#is_installment_payment').on('change', toggleInstallments);

        function addInstallment(installmentData = null) {
          const index = installmentCounter++;
          const $container = $('#installments-container');
          const installment = installmentData || {
            installment_number: index + 1,
            amount: '',
            due_date: ''
          };

          const $installmentDiv = $('<div>')
            .addClass('rounded-lg border border-gray-300 bg-white p-4 dark:border-gray-600 dark:bg-gray-800')
            .html(`
              <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Installment ${index + 1}</h4>
                <button type="button" class="remove-installment text-red-600 hover:text-red-700 text-sm font-medium">
                  Remove
                </button>
              </div>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div>
                  <label class="block text-xs font-medium text-gray-700 mb-1">Installment Number *</label>
                  <input type="number" name="installments[${index}][installment_number]" value="${installment.installment_number}" required
                         min="1" class="installment-number block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <div>
                  <label class="block text-xs font-medium text-gray-700 mb-1">Amount (BDT) *</label>
                  <input type="number" name="installments[${index}][amount]" value="${installment.amount}" required
                         step="0.01" min="0" placeholder="0.00" 
                         class="installment-amount block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
                <div>
                  <label class="block text-xs font-medium text-gray-700 mb-1">Due Date *</label>
                  <input type="date" name="installments[${index}][due_date]" value="${installment.due_date}" required
                         class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                </div>
              </div>
            `);

          $container.append($installmentDiv);

          // Add event listeners
          $installmentDiv.find('.installment-amount').on('input', updateInstallmentSummary);
          $installmentDiv.find('.remove-installment').on('click', function() {
            removeInstallment($(this));
          });

          updateInstallmentSummary();
        }

        function removeInstallment($button) {
          $button.closest('.rounded-lg').remove();
          renumberInstallments();
          updateInstallmentSummary();
        }

        function renumberInstallments() {
          $('#installments-container .rounded-lg').each(function(index) {
            $(this).find('h4').text('Installment ' + (index + 1));
            $(this).find('.installment-number').val(index + 1);
          });
          installmentCounter = $('#installments-container .rounded-lg').length;
        }

        function updateInstallmentSummary() {
          if (!$('#is_installment_payment').is(':checked')) {
            $('#installment-summary').hide();
            return;
          }

          let totalAllocated = 0;
          $('.installment-amount').each(function() {
            const amount = parseFloat($(this).val()) || 0;
            totalAllocated += amount;
          });

          const remaining = currentTotalPrice - totalAllocated;
          const $summary = $('#installment-summary');

          if ($summary.length === 0) {
            $('#installments-section').prepend(`
                <div id="installment-summary" class="mb-4 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 p-4 text-white">
                  <h4 class="mb-2 text-sm font-semibold opacity-90">Installment Summary</h4>
                  <div class="mb-1 flex justify-between text-sm">
                    <span>Total Course Price:</span>
                    <span>BDT ${currentTotalPrice.toFixed(2)}</span>
                  </div>
                  <div class="mb-1 flex justify-between text-sm">
                    <span>Total Allocated:</span>
                    <span>BDT ${totalAllocated.toFixed(2)}</span>
                  </div>
                  <div class="mt-2 flex justify-between border-t border-white/30 pt-2 text-lg font-bold">
                    <span>Remaining Amount:</span>
                    <span>BDT ${remaining.toFixed(2)}</span>
                  </div>
                </div>
              `);
          } else {
            $summary.find('.flex').eq(0).html(`
                <span>Total Course Price:</span>
                <span>BDT ${currentTotalPrice.toFixed(2)}</span>
              `);
            $summary.find('.flex').eq(1).html(`
                <span>Total Allocated:</span>
                <span>BDT ${totalAllocated.toFixed(2)}</span>
              `);
            $summary.find('.text-lg').html(`
                <span>Remaining Amount:</span>
                <span>BDT ${remaining.toFixed(2)}</span>
              `);

            // Add warning if amounts don't match
            if (Math.abs(remaining) > 0.01) {
              $summary.find('.text-lg span:last-child').addClass('text-yellow-200');
            } else {
              $summary.find('.text-lg span:last-child').removeClass('text-yellow-200');
            }
          }

          $summary.show();
        }

        // Add installment button
        $('#add-installment-btn').on('click', function() {
          addInstallment();
        });

        // Initialize
        if ($('#is_installment_payment').is(':checked')) {
          toggleInstallments();
        }
      });
    </script>
  @endpush
@endsection
