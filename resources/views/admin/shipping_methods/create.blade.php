@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Shipping Method</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new shipping option</p>
      </div>
      <x-ui.link href="{{ route('admin.shipping-methods.index') }}" variant="default">
        ← Back to List
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.shipping-methods.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="name" label="Method Name" :value="old('name')" required :error="$errors->first('name')"
                         placeholder="Standard Shipping" />
          <x-forms.input name="price" label="Price (৳)" type="number" step="0.01" min="0" :value="old('price')"
                         required :error="$errors->first('price')" />
        </div>

        <div>
          <x-forms.input name="duration" label="Estimated Duration" :value="old('duration')" :error="$errors->first('duration')"
                         placeholder="e.g. 2-3 Business Days" />
        </div>

        <!-- Status -->
        <div class="flex items-center space-x-3">
          <input type="hidden" name="status" value="0">
          <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.shipping-methods.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Create Method
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
