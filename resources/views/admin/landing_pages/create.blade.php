@extends('layouts.admin')

@section('content')
  <div class="space-y-6" x-data="{ activeTab: 'basic' }">
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

    <!-- Form -->
    <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <!-- Tabs Navigation -->
      @include('admin.landing_pages.partials.tabs')

      <!-- Tab Content -->
      <div class="space-y-6">
        @include('admin.landing_pages.partials.basic_info')
        @include('admin.landing_pages.partials.hero_section')
        @include('admin.landing_pages.partials.pdf_preview')
        @include('admin.landing_pages.partials.book_details')
        @include('admin.landing_pages.partials.features')
        @include('admin.landing_pages.partials.pricing')
        @include('admin.landing_pages.partials.order_form')
        @include('admin.landing_pages.partials.seo_settings')
      </div>

      <!-- Submit Button -->
      <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
        <x-ui.link href="{{ route('admin.landing-pages.index') }}" variant="outline" size="md">
          Cancel
        </x-ui.link>
        <x-button type="submit" variant="primary" size="md">
          <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Create Landing Page
        </x-button>
      </div>
    </form>
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

        // Auto-populate from book when selected
        $('#product-id').on('change', function() {
          const bookId = $(this).val();
          if (bookId) {
            // Fetch book details and populate defaults
            $.get('/admin/books/' + bookId + '/json', function(book) {
              if (book) {
                // Populate hero titles if empty
                if (!$('input[name="hero_english_title"]').val()) {
                  $('input[name="hero_english_title"]').val(book.title ? book.title.toUpperCase() : '');
                }
                // Populate pricing if empty
                if (!$('input[name="pricing_original_price"]').val()) {
                  $('input[name="pricing_original_price"]').val(book.price || '');
                }
                if (!$('input[name="pricing_offer_price"]').val()) {
                  $('input[name="pricing_offer_price"]').val(book.discounted_price || book.price || '');
                }
              }
            }).fail(function() {
              console.log('Could not fetch book details');
            });
          }
        });
      });
    </script>
  @endpush
@endsection
