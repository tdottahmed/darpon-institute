@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Payment Gateway</h1>
        <p class="mt-1 text-sm text-gray-600">Update payment method</p>
      </div>
      <x-ui.link href="{{ route('admin.payment-gateways.index') }}" variant="default">
        ← Back to List
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.payment-gateways.update', $paymentGateway) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="name" label="Gateway Name" :value="old('name', $paymentGateway->name)" required :error="$errors->first('name')" />
          <div>
            <label for="type" class="mb-2 block text-sm font-medium text-gray-700">Payment Type *</label>
            <select name="type" id="type" required
                    class="block w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
              <option value="">Select Type</option>
              <option value="bkash" {{ old('type', $paymentGateway->type) === 'bkash' ? 'selected' : '' }}>Bkash</option>
              <option value="nagad" {{ old('type', $paymentGateway->type) === 'nagad' ? 'selected' : '' }}>Nagad</option>
              <option value="rocket" {{ old('type', $paymentGateway->type) === 'rocket' ? 'selected' : '' }}>Rocket
              </option>
              <option value="bank" {{ old('type', $paymentGateway->type) === 'bank' ? 'selected' : '' }}>Bank Transfer
              </option>
            </select>
            @error('type')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="account_number" label="Account/Phone Number" :value="old('account_number', $paymentGateway->account_number)" :error="$errors->first('account_number')" />
          <x-forms.input name="account_name" label="Account Holder Name" :value="old('account_name', $paymentGateway->account_name)" :error="$errors->first('account_name')" />
        </div>

        <div>
          <label for="instructions" class="mb-2 block text-sm font-medium text-gray-700">Payment Instructions</label>
          <textarea name="instructions" id="instructions" rows="4"
                    class="block w-full rounded-lg border-gray-200 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ old('instructions', $paymentGateway->instructions) }}</textarea>
          @error('instructions')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="order" label="Display Order" type="number" min="0" :value="old('order', $paymentGateway->order)"
                         :error="$errors->first('order')" help="Lower numbers appear first" />
          <!-- Status -->
          <div class="flex items-center space-x-3 pt-6">
            <input type="hidden" name="status" value="0">
            <input type="checkbox" name="status" id="status" value="1"
                   {{ old('status', $paymentGateway->status) ? 'checked' : '' }}
                   class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
            <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.payment-gateways.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update Gateway
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection








