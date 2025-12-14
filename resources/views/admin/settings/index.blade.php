@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
        <p class="mt-1 text-sm text-gray-600">Manage site-wide configuration</p>
      </div>
    </div>

    <!-- Steadfast API Settings -->
    <x-card variant="elevated">
      <div class="px-4 py-3 border-b border-gray-200 mb-6 -mx-6 -mt-6 rounded-t-lg bg-gray-50">
          <h2 class="text-lg font-medium text-gray-900">Steadfast Courier API</h2>
          <p class="text-sm text-gray-500">Configure API credentials for shipping integration</p>
      </div>

      <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6">
          <x-forms.input name="steadfast_api_key" label="API Key" :value="old('steadfast_api_key', $settings['steadfast_api_key'])" :error="$errors->first('steadfast_api_key')" placeholder="Enter API Key from Steadfast Dashboard" />
          
          <div class="space-y-1">
             <label for="steadfast_secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
             <input type="password" name="steadfast_secret_key" id="steadfast_secret_key" 
                    value="{{ old('steadfast_secret_key', $settings['steadfast_secret_key']) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                    placeholder="Enter Secret Key">
             @if($errors->has('steadfast_secret_key'))
                <p class="mt-1 text-sm text-red-600">{{ $errors->first('steadfast_secret_key') }}</p>
             @endif
          </div>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6 mt-6">
          <x-button type="submit" variant="primary" size="md">
            Save Changes
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
