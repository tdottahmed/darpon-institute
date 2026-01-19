@php
  $activeTab = request()->get('tab', 'basic');
@endphp

@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Landing Page</h1>
        <p class="mt-1 text-sm text-gray-600">Edit landing page details</p>
      </div>
      <x-ui.link href="{{ route('admin.landing-pages.index') }}" variant="default">
        ← Back to Landing Pages
      </x-ui.link>
    </div>

    <!-- Tabs Navigation -->
    @include('admin.landing_pages.partials.tabs')

    <!-- Tab Content -->
    <div class="space-y-6">
      @if ($activeTab === 'basic')
        @include('admin.landing_pages.partials.basic_info')
      @elseif($activeTab === 'hero')
        @include('admin.landing_pages.partials.hero_section')
      @elseif($activeTab === 'pdf')
        @include('admin.landing_pages.partials.pdf_preview')
      @elseif($activeTab === 'book-details')
        @include('admin.landing_pages.partials.book_details')
      @elseif($activeTab === 'features')
        @include('admin.landing_pages.partials.features')
      @elseif($activeTab === 'pricing')
        @include('admin.landing_pages.partials.pricing')
      @elseif($activeTab === 'order')
        @include('admin.landing_pages.partials.order_form')
      @elseif($activeTab === 'seo')
        @include('admin.landing_pages.partials.seo_settings')
      @endif
    </div>
  </div>

  @push('scripts')
    <script>
      $(document).ready(function() {
        // Auto-generate slug from title
        $('#landing-title').on('input', function() {
          const title = $(this).val();
          const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
          $('#landing-slug').val(slug);
        });

        // Initialize state
        const initialType = $('input[name="product_type"]:checked').val();
        toggleProductSelect(initialType);

        // Handle product type change
        $('input[name="product_type"]').on('change', function() {
          const type = $(this).val();
          toggleProductSelect(type);
        });

        function toggleProductSelect(type) {
          if (type === 'book') {
            $('#book-select-container').show().find('select, input').prop('disabled', false);
            $('#course-select-container').hide().find('select, input').prop('disabled', true);
          } else {
            $('#course-select-container').show().find('select, input').prop('disabled', false);
            $('#book-select-container').hide().find('select, input').prop('disabled', true);
          }
        }
      });
    </script>
  @endpush
@endsection
