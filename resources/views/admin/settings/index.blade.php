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

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
      @csrf

      @include('admin.settings.partials.steadfast')
      @include('admin.settings.partials.fraud_check')
      @include('admin.settings.partials.meta_pixel')
      @include('admin.settings.partials.social_links')
      @include('admin.settings.partials.company_info')
      @include('admin.settings.partials.seo_analytics')
      @include('admin.settings.partials.logo')
      @include('admin.settings.partials.smtp_setup')

      <!-- Submit Button -->
      <div class="flex items-center justify-end gap-4 pt-2">
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
