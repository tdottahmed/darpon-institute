@php
  $activeTab = request()->get('tab', 'basic');
@endphp

@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Landing Page</h1>
        <p class="mt-1 text-sm text-gray-600">Create a custom landing page for a book</p>
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
      @elseif($activeTab === 'author')
        @include('admin.landing_pages.partials.author_info')
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

        // Auto-populate from book when selected
        $('#book-id').on('change', function() {
          const bookId = $(this).val();
          if (bookId) {
            $.get('/admin/books/' + bookId + '/json', function(book) {
              if (book) populateDefaults(book);
            }).fail(function() { console.log('Could not fetch book details'); });
          }
        });

        // Auto-populate from course when selected
        $('#course-id').on('change', function() {
          const courseId = $(this).val();
          if (courseId) {
            $.get('/admin/courses/' + courseId + '/json', function(course) {
              if (course) populateDefaults(course);
            }).fail(function() { console.log('Could not fetch course details'); });
          }
        });

        function populateDefaults(data) {
           // Populate hero titles if empty
           if (!$('input[name="hero_english_title"]').val()) {
              $('input[name="hero_english_title"]').val(data.title ? data.title.toUpperCase() : '');
           }
           // Populate pricing if empty
           if (!$('input[name="pricing_original_price"]').val()) {
              $('input[name="pricing_original_price"]').val(data.price || '');
           }
           if (!$('input[name="pricing_offer_price"]').val()) {
              $('input[name="pricing_offer_price"]').val(data.discounted_price || data.price || '');
           }
        }
      });
    </script>
  @endpush
@endsection
