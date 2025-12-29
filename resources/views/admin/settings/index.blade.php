@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">General Settings</h1>
        <p class="mt-1 text-sm text-gray-600">Manage site-wide configuration and API credentials</p>
      </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Steadfast Courier API Settings -->
      <x-card variant="elevated">
        <div class="px-4 py-3 border-b border-gray-200 mb-6 -mx-6 -mt-6 rounded-t-lg bg-gray-50">
          <h2 class="text-lg font-medium text-gray-900">Steadfast Courier API</h2>
          <p class="text-sm text-gray-500">Configure API credentials for shipping integration</p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <x-forms.input name="steadfast_api_key" label="API Key" type="text" 
                         :value="old('steadfast_api_key', $settings['steadfast_api_key'])" 
                         :error="$errors->first('steadfast_api_key')" 
                         placeholder="Enter API Key from Steadfast Dashboard" />
          
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
      </x-card>

      <!-- Fraud Check Credentials -->
      <x-card variant="elevated">
        <div class="px-4 py-3 border-b border-gray-200 mb-6 -mx-6 -mt-6 rounded-t-lg bg-gray-50">
          <h2 class="text-lg font-medium text-gray-900">Fraud Check Credentials</h2>
          <p class="text-sm text-gray-500">Configure credentials for courier fraud checking service</p>
          <p class="mt-1 text-xs text-gray-400">These settings will override values in your .env file</p>
        </div>

        <div class="space-y-8">
          <!-- Pathao Credentials -->
          <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
            <h3 class="mb-4 text-base font-semibold text-gray-900 flex items-center gap-2">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Pathao Credentials
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="pathao_user" label="Email/Username" type="email" 
                             :value="old('pathao_user', $settings['pathao_user'])" 
                             :error="$errors->first('pathao_user')" 
                             placeholder="developertanbir1@gmail.com" />
              
              <div class="space-y-1">
                <label for="pathao_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="pathao_password" id="pathao_password" 
                       value="{{ old('pathao_password', $settings['pathao_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Pathao password">
                @if($errors->has('pathao_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('pathao_password') }}</p>
                @endif
              </div>
            </div>
          </div>

          <!-- Steadfast Credentials -->
          <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
            <h3 class="mb-4 text-base font-semibold text-gray-900 flex items-center gap-2">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Steadfast Credentials (Fraud Check)
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="steadfast_user" label="Email/Username" type="email" 
                             :value="old('steadfast_user', $settings['steadfast_user'])" 
                             :error="$errors->first('steadfast_user')" 
                             placeholder="developertanbir1@gmail.com" />
              
              <div class="space-y-1">
                <label for="steadfast_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="steadfast_password" id="steadfast_password" 
                       value="{{ old('steadfast_password', $settings['steadfast_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Steadfast password">
                @if($errors->has('steadfast_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('steadfast_password') }}</p>
                @endif
              </div>
            </div>
          </div>

          <!-- Redex Credentials -->
          <div>
            <h3 class="mb-4 text-base font-semibold text-gray-900 flex items-center gap-2">
              <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Redex Credentials
            </h3>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
              <x-forms.input name="redx_phone" label="Phone Number" type="text" 
                             :value="old('redx_phone', $settings['redx_phone'])" 
                             :error="$errors->first('redx_phone')" 
                             placeholder="01345274871" />
              
              <div class="space-y-1">
                <label for="redx_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="redx_password" id="redx_password" 
                       value="{{ old('redx_password', $settings['redx_password']) }}"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                       placeholder="Enter Redex password">
                @if($errors->has('redx_password'))
                  <p class="mt-1 text-sm text-red-600">{{ $errors->first('redx_password') }}</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </x-card>

      <!-- Submit Button -->
      <div class="flex items-center justify-end gap-4">
        <x-button type="submit" variant="primary" size="md">
          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Save All Settings
        </x-button>
      </div>
    </form>
  </div>
@endsection
