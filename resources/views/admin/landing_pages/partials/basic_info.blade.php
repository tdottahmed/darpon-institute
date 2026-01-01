<!-- Basic Information Tab -->
<div x-show="activeTab === 'basic'" class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Basic Information</h2>
      <p class="text-sm text-gray-500">Essential details for the landing page</p>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
      <x-forms.input name="title" label="Title" :value="old('title', isset($landingPage) ? $landingPage->title : '')" required 
                     :error="$errors->first('title')" id="landing-title"
                     placeholder="Enter landing page title" />
      <x-forms.input name="slug" label="Slug" :value="old('slug', isset($landingPage) ? $landingPage->slug : '')" required 
                     :error="$errors->first('slug')"
                     help="URL-friendly version (e.g., spoken-english-book)" id="landing-slug" />
    </div>

    <div class="mt-6">
      <x-forms.select name="product_id" label="Select Book" :options="$books" 
                      :value="old('product_id', isset($landingPage) ? $landingPage->product_id : '')" required
                      :error="$errors->first('product_id')" id="product-id" 
                      help="Select a book for this landing page" />
    </div>

    <!-- Section Visibility Toggles -->
    <div class="mt-6 space-y-3">
      <h3 class="text-sm font-medium text-gray-900">Section Visibility</h3>
      <p class="text-xs text-gray-500 mb-3">Toggle which sections should be displayed on the frontend</p>
      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_hero" value="0">
          <input type="checkbox" name="show_hero" value="1" 
                 {{ old('show_hero', isset($landingPage) ? ($landingPage->show_hero ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">Hero Section</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_pdf_preview" value="0">
          <input type="checkbox" name="show_pdf_preview" value="1"
                 {{ old('show_pdf_preview', isset($landingPage) ? ($landingPage->show_pdf_preview ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">PDF Preview</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_book_details" value="0">
          <input type="checkbox" name="show_book_details" value="1"
                 {{ old('show_book_details', isset($landingPage) ? ($landingPage->show_book_details ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">Book Details</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_features" value="0">
          <input type="checkbox" name="show_features" value="1"
                 {{ old('show_features', isset($landingPage) ? ($landingPage->show_features ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">Features</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_pricing" value="0">
          <input type="checkbox" name="show_pricing" value="1"
                 {{ old('show_pricing', isset($landingPage) ? ($landingPage->show_pricing ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">Pricing</span>
        </label>
        <label class="flex items-center space-x-2">
          <input type="hidden" name="show_order" value="0">
          <input type="checkbox" name="show_order" value="1"
                 {{ old('show_order', isset($landingPage) ? ($landingPage->show_order ?? true) : true) ? 'checked' : '' }}
                 class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
          <span class="text-sm text-gray-700">Order Form</span>
        </label>
      </div>
    </div>

    <!-- Status -->
    <div class="mt-6 flex items-center space-x-3">
      <input type="hidden" name="status" value="0">
      <input type="checkbox" name="status" id="status" value="1"
             {{ old('status', isset($landingPage) ? ($landingPage->status ?? 1) : 1) ? 'checked' : '' }}
             class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
      <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
      <span class="text-xs text-gray-500">Only active landing pages will be visible on the frontend</span>
    </div>
  </x-card>
</div>

