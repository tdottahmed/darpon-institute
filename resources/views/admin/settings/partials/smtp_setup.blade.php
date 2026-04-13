<!-- SMTP Settings -->
<x-card variant="elevated">
<div class="-mx-6 -mt-6 mb-6 rounded-t-lg border-b border-gray-200 bg-gray-50 px-4 py-3">
  <h2 class="text-lg font-medium text-gray-900">SMTP Server Configuration</h2>
  <p class="text-sm text-gray-500">Global mail sending credentials updated permanently in the environment</p>
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
  <x-forms.input name="smtp_mailer" label="Mail Protocol (Mailer)" type="text" :value="old('smtp_mailer', $settings['smtp_mailer'] ?? 'smtp')" :error="$errors->first('smtp_mailer')"
                 placeholder="smtp" />
                 
  <x-forms.input name="smtp_host" label="Mail Host" type="text" :value="old('smtp_host', $settings['smtp_host'] ?? '')" :error="$errors->first('smtp_host')"
                 placeholder="smtp.mailtrap.io" />

  <x-forms.input name="smtp_port" label="Mail Port" type="text" :value="old('smtp_port', $settings['smtp_port'] ?? '2525')" :error="$errors->first('smtp_port')"
                 placeholder="2525 / 465 / 587" />

  <x-forms.input name="smtp_encryption" label="Mail Encryption" type="text" :value="old('smtp_encryption', $settings['smtp_encryption'] ?? '')" :error="$errors->first('smtp_encryption')"
                 placeholder="tls / ssl" />

  <x-forms.input name="smtp_username" label="Mail Username" type="text" :value="old('smtp_username', $settings['smtp_username'] ?? '')" :error="$errors->first('smtp_username')"
                 placeholder="Username / Email" />

  <div class="space-y-1">
    <label for="smtp_password" class="block text-sm font-medium text-gray-700">Mail Password</label>
    <div class="relative rounded-md shadow-sm">
      <input type="password" name="smtp_password" id="smtp_password"
             value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}"
             class="block w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
             placeholder="Mail App Password">
    </div>
    @if ($errors->has('smtp_password'))
      <p class="mt-1 text-sm text-red-600">{{ $errors->first('smtp_password') }}</p>
    @endif
  </div>

  <div class="col-span-1 md:col-span-1">
    <x-forms.input name="smtp_from_address" label="Mail From Address" type="email" :value="old('smtp_from_address', $settings['smtp_from_address'] ?? '')" :error="$errors->first('smtp_from_address')"
                   placeholder="noreply@domain.com" />
  </div>

  <div class="col-span-1 md:col-span-1">
    <x-forms.input name="smtp_from_name" label="Mail From Name" type="text" :value="old('smtp_from_name', $settings['smtp_from_name'] ?? '')" :error="$errors->first('smtp_from_name')"
                   placeholder="Darpon Edutech" />
  </div>

</div>
</x-card>
