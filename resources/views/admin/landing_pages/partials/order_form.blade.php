@php
  $formAction = isset($landingPage) 
    ? route('admin.landing-pages.update-partial', $landingPage)
    : route('admin.landing-pages.store-partial');
@endphp

<!-- Order Form Tab -->
<div class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Order Form Section</h2>
      <p class="text-sm text-gray-500">Order form configuration, shipping, and payment information</p>
    </div>

    <form action="{{ $formAction }}" method="POST">
      @csrf
      @if(isset($landingPage))
        @method('PUT')
      @endif
      <input type="hidden" name="tab" value="order">

      <div class="space-y-6">
      <x-forms.input name="order_section_title" label="Section Title" 
                     :value="old('order_section_title', isset($landingPage) ? $landingPage->order_section_title : 'Order Now')" 
                     :error="$errors->first('order_section_title')"
                     help="Title displayed at the top of the order form section" />

      <div class="space-y-4">
        <label class="block text-sm font-medium text-gray-700">Order Form Fields (JSON Array)</label>
        <p class="text-xs text-gray-500 mb-2">Array of field names that will be displayed in the order form. Common fields: Name, Phone, Address, Country/Region, Email, etc.</p>
        <textarea name="order_form_fields" rows="4"
                  class="block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
                  placeholder='["Name", "Phone", "Address", "Country/Region"]'>{{ old('order_form_fields', isset($landingPage) && $landingPage->order_form_fields ? json_encode($landingPage->order_form_fields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '["Name", "Phone", "Address", "Country/Region"]') }}</textarea>
        <x-forms.error :message="$errors->first('order_form_fields')" />
      </div>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <x-forms.input name="order_shipping_charge" label="Shipping Charge (BDT)" type="number"
                       step="0.01" :value="old('order_shipping_charge', isset($landingPage) ? ($landingPage->order_shipping_charge ?? 90) : 90)"
                       :error="$errors->first('order_shipping_charge')" 
                       help="Shipping/delivery charge in BDT" />
        <x-forms.input name="order_shipping_note" label="Shipping Note" 
                       :value="old('order_shipping_note', isset($landingPage) ? $landingPage->order_shipping_note : '')" 
                       :error="$errors->first('order_shipping_note')"
                       placeholder="সারা বাংলাদেশে হোম ডেলিভারি চার্জ" 
                       help="Description text about shipping/delivery" />
      </div>

      <x-forms.input name="order_payment_note" label="Payment Note" 
                     :value="old('order_payment_note', isset($landingPage) ? $landingPage->order_payment_note : '')" 
                     :error="$errors->first('order_payment_note')"
                     placeholder="Pay with cash upon delivery." 
                     help="Important note about payment method. This will be displayed in the payment section." />

      <div class="rounded-md bg-green-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800">Order Form Features</h3>
            <div class="mt-2 text-sm text-green-700">
              <ul class="list-disc space-y-1 pl-5">
                <li>The order form will be displayed with billing details on the left and order summary on the right</li>
                <li>Total price will be calculated as: Offer Price + Shipping Charge</li>
                <li>Form fields are customizable via the JSON array above</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <a href="{{ isset($landingPage) ? route('admin.landing-pages.edit', $landingPage) : route('admin.landing-pages.create') }}?tab=order"
             class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500">
            Cancel
          </a>
          <x-button type="submit" variant="primary" size="md">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ isset($landingPage) ? 'Update Order Form' : 'Save Order Form' }}
          </x-button>
        </div>
      </div>
    </form>
  </x-card>
</div>

