@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
        <p class="mt-1 text-sm text-gray-600">Add a new user to the platform</p>
      </div>
      <x-ui.link href="{{ route('admin.users.index') }}" variant="default">
        ← Back to Users
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="name" label="Full Name" :value="old('name')" required :error="$errors->first('name')" />

          <x-forms.input name="email" type="email" label="Email Address" :value="old('email')" required
                         :error="$errors->first('email')" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.select name="user_type" label="User Type" :options="['admin' => 'Admin', 'customer' => 'Customer']" :value="old('user_type', 'customer')" required
                          :error="$errors->first('user_type')" />

        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="password" type="password" label="Password" required :error="$errors->first('password')"
                         help="Must be at least 8 characters" />

          <x-forms.input name="password_confirmation" type="password" label="Confirm Password" required
                         :error="$errors->first('password_confirmation')" />
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.users.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Create User
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
