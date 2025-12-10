@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
        <p class="mt-1 text-sm text-gray-600">Update user information</p>
      </div>
      <x-ui.link href="{{ route('admin.users.index') }}" variant="default">
        ← Back to Users
      </x-ui.link>
    </div>

    <!-- Form -->
    <x-card variant="elevated">
      <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.input name="name" label="Full Name" :value="old('name', $user->name)" required :error="$errors->first('name')" />

          <x-forms.input name="email" type="email" label="Email Address" :value="old('email', $user->email)" required
                         :error="$errors->first('email')" />
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <x-forms.select name="user_type" label="User Type" :options="['admin' => 'Admin', 'customer' => 'Customer']" :value="old('user_type', $user->user_type)" required
                          :error="$errors->first('user_type')" />

          <div></div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
          <p class="mb-2 text-sm font-medium text-gray-700">Change Password (Optional)</p>
          <p class="mb-4 text-xs text-gray-500">Leave blank if you don't want to change the password</p>

          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <x-forms.input name="password" type="password" label="New Password" :error="$errors->first('password')"
                           help="Must be at least 8 characters" />

            <x-forms.input name="password_confirmation" type="password" label="Confirm New Password" :error="$errors->first('password_confirmation')" />
          </div>
        </div>

        <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
          <x-ui.link href="{{ route('admin.users.index') }}" variant="default">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update User
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
