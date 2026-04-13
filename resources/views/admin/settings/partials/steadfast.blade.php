<!-- Steadfast Courier API Settings -->
<x-card variant="elevated">
  <div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
    <h2 class="text-lg font-medium text-gray-900">Steadfast Courier API</h2>
    <p class="text-sm text-gray-500">Configure API credentials for shipping integration</p>
  </div>

  <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <x-forms.input name="steadfast_api_key" label="API Key" type="text" :value="old('steadfast_api_key', $settings['steadfast_api_key'])" :error="$errors->first('steadfast_api_key')"
                   placeholder="Enter API Key from Steadfast Dashboard" />

    <div class="space-y-1">
      <label for="steadfast_secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
      <input type="password" name="steadfast_secret_key" id="steadfast_secret_key"
             value="{{ old('steadfast_secret_key', $settings['steadfast_secret_key']) }}"
             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
             placeholder="Enter Secret Key">
      @if ($errors->has('steadfast_secret_key'))
        <p class="mt-1 text-sm text-red-600">{{ $errors->first('steadfast_secret_key') }}</p>
      @endif
    </div>
  </div>
</x-card>
