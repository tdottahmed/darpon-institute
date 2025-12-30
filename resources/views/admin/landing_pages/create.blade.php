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
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
          <button type="button" @click="activeTab = 'basic'" 
                  :class="activeTab === 'basic' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Basic Info
          </button>
          <button type="button" @click="activeTab = 'hero'" 
                  :class="activeTab === 'hero' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Hero Section
          </button>
          <button type="button" @click="activeTab = 'pdf'" 
                  :class="activeTab === 'pdf' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            PDF Preview
          </button>
          <button type="button" @click="activeTab = 'book-details'" 
                  :class="activeTab === 'book-details' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Book Details
          </button>
          <button type="button" @click="activeTab = 'features'" 
                  :class="activeTab === 'features' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Features
          </button>
          <button type="button" @click="activeTab = 'pricing'" 
                  :class="activeTab === 'pricing' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Pricing
          </button>
          <button type="button" @click="activeTab = 'order'" 
                  :class="activeTab === 'order' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            Order Form
          </button>
          <button type="button" @click="activeTab = 'seo'" 
                  :class="activeTab === 'seo' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                  class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
            SEO & Settings
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="space-y-6">
        <!-- Basic Information Tab -->
        <div x-show="activeTab === 'basic'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
              <p class="text-sm text-gray-500">Essential details for the landing page</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              <x-forms.input name="title" label="Title" :value="old('title')" required :error="$errors->first('title')" id="landing-title"
                             placeholder="Enter landing page title" />
              <x-forms.input name="slug" label="Slug" :value="old('slug')" required :error="$errors->first('slug')"
                             help="URL-friendly version (e.g., spoken-english-book)" id="landing-slug" />
            </div>

            <div class="mt-6">
              <x-forms.select name="product_id" label="Select Book" :options="$books" :value="old('product_id')" required
                              :error="$errors->first('product_id')" id="product-id"
                              help="Select a book for this landing page" />
            </div>

            <!-- Section Visibility Toggles -->
            <div class="mt-6 space-y-3">
              <h3 class="text-sm font-medium text-gray-900">Section Visibility</h3>
              <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_hero" value="0">
                  <input type="checkbox" name="show_hero" value="1" {{ old('show_hero', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">Hero Section</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_pdf_preview" value="0">
                  <input type="checkbox" name="show_pdf_preview" value="1" {{ old('show_pdf_preview', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">PDF Preview</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_book_details" value="0">
                  <input type="checkbox" name="show_book_details" value="1" {{ old('show_book_details', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">Book Details</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_features" value="0">
                  <input type="checkbox" name="show_features" value="1" {{ old('show_features', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">Features</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_pricing" value="0">
                  <input type="checkbox" name="show_pricing" value="1" {{ old('show_pricing', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">Pricing</span>
                </label>
                <label class="flex items-center space-x-2">
                  <input type="hidden" name="show_order" value="0">
                  <input type="checkbox" name="show_order" value="1" {{ old('show_order', true) ? 'checked' : '' }}
                         class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                  <span class="text-sm text-gray-700">Order Form</span>
                </label>
              </div>
            </div>

            <!-- Status -->
            <div class="mt-6 flex items-center space-x-3">
              <input type="hidden" name="status" value="0">
              <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                     class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
              <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
            </div>
          </x-card>
        </div>

        <!-- Hero Section Tab -->
        <div x-show="activeTab === 'hero'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Hero Section</h2>
              <p class="text-sm text-gray-500">Main banner area at the top of the landing page</p>
            </div>

            <div class="space-y-6">
              <x-forms.input name="hero_english_title" label="English Title" :value="old('hero_english_title')" :error="$errors->first('hero_english_title')"
                             placeholder="SPOKEN ENGLISH IN REAL LIFE" help="Main English title (will be uppercase)" />
              <x-forms.textarea name="hero_bengali_title" label="Bengali Title" :value="old('hero_bengali_title')" rows="3"
                                :error="$errors->first('hero_bengali_title')" placeholder="ইংরেজি শেখার একমাত্র বই..." />
              <x-forms.image-uploader name="hero_main_image" label="Main Hero Image" :value="old('hero_main_image')" accept="image/*"
                                      maxSize="2MB" :error="$errors->first('hero_main_image')" help="Main book image in hero section" />
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hero Preview Images</label>
                <p class="mb-3 text-xs text-gray-500">Upload multiple preview images for the carousel</p>
                <input type="file" name="hero_preview_images[]" multiple accept="image/*"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <x-forms.error :message="$errors->first('hero_preview_images.*')" />
              </div>
            </div>
          </x-card>
        </div>

        <!-- PDF Preview Tab -->
        <div x-show="activeTab === 'pdf'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">PDF Preview Section</h2>
              <p class="text-sm text-gray-500">PDF preview cards with images and links</p>
            </div>

            <div class="space-y-4">
              <label class="block text-sm font-medium text-gray-700">PDF Previews (JSON)</label>
              <textarea name="pdf_previews" rows="12" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                        placeholder='[
  {
    "image": "https://example.com/preview1.png",
    "pdf_url": "https://example.com/book1.pdf",
    "title": "Preview 1"
  }
]'>{{ old('pdf_previews') }}</textarea>
              <p class="text-xs text-gray-500">Enter JSON array with objects containing: image (URL), pdf_url, and title</p>
              <x-forms.error :message="$errors->first('pdf_previews')" />
            </div>
          </x-card>
        </div>

        <!-- Book Details Tab -->
        <div x-show="activeTab === 'book-details'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Book Details Section</h2>
              <p class="text-sm text-gray-500">Detailed information about the book</p>
            </div>

            <div class="space-y-6">
              <x-forms.input name="book_details_title" label="Section Title" :value="old('book_details_title')" :error="$errors->first('book_details_title')"
                             placeholder="বইটি সম্পর্কে যা না জানলেই নয়" />
              <x-forms.rich-text name="book_details_description" label="Description" :value="old('book_details_description')"
                                 height="300px" :error="$errors->first('book_details_description')" />
              
              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Book Specialties (JSON)</label>
                <textarea name="book_details_specialties" rows="8" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='[
  {
    "title": "১০৮ টি লেসন",
    "description": "বিস্তারিত বর্ণনা"
  }
]'>{{ old('book_details_specialties') }}</textarea>
                <x-forms.error :message="$errors->first('book_details_specialties')" />
              </div>

              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Extraordinary Points (JSON)</label>
                <textarea name="book_details_extraordinary" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='["Point 1", "Point 2", "Point 3"]'>{{ old('book_details_extraordinary') }}</textarea>
                <x-forms.error :message="$errors->first('book_details_extraordinary')" />
              </div>

              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Why Students Love (JSON)</label>
                <textarea name="book_details_students_love" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='["Reason 1", "Reason 2", "Reason 3"]'>{{ old('book_details_students_love') }}</textarea>
                <x-forms.error :message="$errors->first('book_details_students_love')" />
              </div>
            </div>
          </x-card>
        </div>

        <!-- Features Tab -->
        <div x-show="activeTab === 'features'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Features Section</h2>
              <p class="text-sm text-gray-500">Book features and target audience information</p>
            </div>

            <div class="space-y-6">
              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Features List (JSON)</label>
                <textarea name="features_list" rows="15" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='[
  {
    "title": "বইটির অসাধারণ কিছু বৈশিষ্ট্য",
    "items": [
      {
        "text": "বৈশিষ্ট্য ১",
        "icon_color": "#1a237e"
      }
    ]
  }
]'>{{ old('features_list') }}</textarea>
                <x-forms.error :message="$errors->first('features_list')" />
              </div>

              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Target Audience List (JSON)</label>
                <textarea name="target_audience_list" rows="15" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='[
  {
    "title": "বইটি মূলত কাদের জন্য?",
    "items": [
      {
        "text": "দর্শক ১",
        "icon_color": "#1565c0"
      }
    ]
  }
]'>{{ old('target_audience_list') }}</textarea>
                <x-forms.error :message="$errors->first('target_audience_list')" />
              </div>

              <x-forms.input name="game_changer_title" label="Game Changer Title" :value="old('game_changer_title')" :error="$errors->first('game_changer_title')"
                             placeholder="কেন এই বই একটি গেম চেঞ্জার" />
              
              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Game Changer Points (JSON Array)</label>
                <textarea name="game_changer_points" rows="6" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='["বাস্তব কথোপকথন", "ব্যবহারিক অভিব্যক্তি", "স্পষ্ট উদাহরণ"]'>{{ old('game_changer_points') }}</textarea>
                <x-forms.error :message="$errors->first('game_changer_points')" />
              </div>

              <x-forms.textarea name="game_changer_conclusion" label="Game Changer Conclusion" :value="old('game_changer_conclusion')" rows="3"
                                :error="$errors->first('game_changer_conclusion')" />
            </div>
          </x-card>
        </div>

        <!-- Pricing Tab -->
        <div x-show="activeTab === 'pricing'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Pricing Section</h2>
              <p class="text-sm text-gray-500">Book pricing and offer information</p>
            </div>

            <div class="space-y-6">
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-forms.input name="pricing_original_price" label="Original Price (BDT)" type="number" step="0.01" :value="old('pricing_original_price')"
                               :error="$errors->first('pricing_original_price')" placeholder="1280" />
                <x-forms.input name="pricing_offer_price" label="Offer Price (BDT)" type="number" step="0.01" :value="old('pricing_offer_price')"
                               :error="$errors->first('pricing_offer_price')" placeholder="750" />
              </div>
              <x-forms.textarea name="pricing_description" label="Pricing Description" :value="old('pricing_description')" rows="3"
                                :error="$errors->first('pricing_description')" placeholder="বিশেষ অফারের বর্ণনা" />
              <x-forms.input name="pricing_note" label="Pricing Note" :value="old('pricing_note')" :error="$errors->first('pricing_note')"
                             placeholder="অর্ডার করতে ১ টাকা অগ্রীম পেমেন্ট করতে হবে না" />
            </div>
          </x-card>
        </div>

        <!-- Order Form Tab -->
        <div x-show="activeTab === 'order'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">Order Form Section</h2>
              <p class="text-sm text-gray-500">Order form configuration</p>
            </div>

            <div class="space-y-6">
              <x-forms.input name="order_section_title" label="Section Title" :value="old('order_section_title', 'Order Now')" :error="$errors->first('order_section_title')" />
              
              <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Order Form Fields (JSON Array)</label>
                <textarea name="order_form_fields" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 font-mono text-sm"
                          placeholder='["Name", "Phone", "Address", "Country/Region"]'>{{ old('order_form_fields', '["Name", "Phone", "Address", "Country/Region"]') }}</textarea>
                <p class="text-xs text-gray-500">Enter JSON array of field names</p>
                <x-forms.error :message="$errors->first('order_form_fields')" />
              </div>

              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-forms.input name="order_shipping_charge" label="Shipping Charge (BDT)" type="number" step="0.01" :value="old('order_shipping_charge', 90)"
                               :error="$errors->first('order_shipping_charge')" />
                <x-forms.input name="order_shipping_note" label="Shipping Note" :value="old('order_shipping_note')" :error="$errors->first('order_shipping_note')"
                               placeholder="সারা বাংলাদেশে হোম ডেলিভারি চার্জ" />
              </div>
              <x-forms.input name="order_payment_note" label="Payment Note" :value="old('order_payment_note')" :error="$errors->first('order_payment_note')"
                             placeholder="Pay with cash upon delivery." />
            </div>
          </x-card>
        </div>

        <!-- SEO & Settings Tab -->
        <div x-show="activeTab === 'seo'" class="space-y-6">
          <x-card variant="elevated">
            <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
              <h2 class="text-lg font-medium text-gray-900">SEO Settings</h2>
              <p class="text-sm text-gray-500">Optimize your landing page for search engines</p>
            </div>

            <div class="space-y-6">
              <x-forms.input name="meta_title" label="Meta Title" :value="old('meta_title')"
                             :error="$errors->first('meta_title')" placeholder="SEO title (50-60 characters)" />
              <x-forms.textarea name="meta_description" label="Meta Description" :value="old('meta_description')" rows="3"
                                :error="$errors->first('meta_description')"
                                placeholder="SEO description (150-160 characters)" />
              <x-forms.image-uploader name="meta_image" label="Meta Image (OG Image)" :value="old('meta_image')"
                                      accept="image/*" maxSize="2MB" :error="$errors->first('meta_image')"
                                      help="Image for social media sharing (1200x630px recommended)" />
            </div>
          </x-card>
        </div>
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
                  $('input[name="hero_english_title"]').val(book.title.toUpperCase());
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
