<!-- Pricing Tab -->
<div x-show="activeTab === 'pricing'" class="space-y-6">
  <x-card variant="elevated">
    <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
      <h2 class="text-lg font-medium text-gray-900">Pricing Section</h2>
      <p class="text-sm text-gray-500">Book pricing, offers, and promotional information</p>
    </div>

    <div class="space-y-6">
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <x-forms.input name="pricing_original_price" label="Original Price (BDT)" type="number"
                       step="0.01" :value="old('pricing_original_price', isset($landingPage) ? $landingPage->pricing_original_price : '')"
                       :error="$errors->first('pricing_original_price')" placeholder="1280" 
                       help="Original/regular price of the book" />
        <x-forms.input name="pricing_offer_price" label="Offer Price (BDT)" type="number" step="0.01"
                       :value="old('pricing_offer_price', isset($landingPage) ? $landingPage->pricing_offer_price : '')"
                       :error="$errors->first('pricing_offer_price')" placeholder="750" 
                       help="Special offer/discounted price" />
      </div>

      <x-forms.textarea name="pricing_description" label="Pricing Description" 
                        :value="old('pricing_description', isset($landingPage) ? $landingPage->pricing_description : '')"
                        rows="4" :error="$errors->first('pricing_description')" 
                        placeholder="বইটির বিশেষ পরিচিতির জন্য আমরা প্রথম ৫০০ জন পাঠককে দিচ্ছি মাত্র ৭৫০ টাকায়। অফারটি সীমিত সময়ের জন্য তাই আপনার কপিটি আজই নিশ্চিত করুন।"
                        help="Description text about the pricing offer. This will be displayed below the prices." />

      <x-forms.input name="pricing_note" label="Pricing Note" 
                     :value="old('pricing_note', isset($landingPage) ? $landingPage->pricing_note : '')" 
                     :error="$errors->first('pricing_note')"
                     placeholder="অর্ডার করতে ১ টাকা অগ্রীম পেমেন্ট করতে হবে না" 
                     help="Important note about payment/pricing. This will be displayed prominently in red text." />

      <div class="rounded-md bg-yellow-50 p-4">
        <div class="flex">
          <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">Price Display</h3>
            <div class="mt-2 text-sm text-yellow-700">
              <p>The original price will be displayed with a strikethrough effect, and the offer price will be highlighted prominently. Make sure both prices are set correctly.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </x-card>
</div>

