@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Add New Instructor</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new instructor profile</p>
      </div>
      <x-ui.link href="{{ route('admin.teachers.index') }}" variant="secondary" size="md">
        Back to List
      </x-ui.link>
    </div>

    <x-card variant="elevated">
      <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <!-- Name -->
          <div>
            <x-forms.input label="Name" type="text" name="name" id="name" value="{{ old('name') }}" required :error="$errors->first('name')" />
          </div>

          <!-- Designation -->
          <div>
            <x-forms.input label="Designation" type="text" name="designation" id="designation" value="{{ old('designation') }}" required placeholder="e.g. Assistant Professor" :error="$errors->first('designation')" />
          </div>

          <!-- Department -->
          <div>
            <x-forms.input label="Department" type="text" name="department" id="department" value="{{ old('department') }}" required placeholder="e.g. English" :error="$errors->first('department')" />
          </div>

          <!-- Order -->
          <div>
            <x-forms.input label="Display Order" type="number" name="order" id="order" value="{{ old('order', 0) }}" required min="0" :error="$errors->first('order')" />
            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
          </div>
        </div>

        <!-- Image -->
        <div>
          <x-forms.label for="image">Profile Image</x-forms.label>
          <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" accept="image/*">
          <p class="mt-1 text-xs text-gray-500">Recommended size: 500x500px. Max size: 2MB.</p>
          <x-forms.error :message="$errors->first('image')" />
        </div>

        <!-- Status -->
        <div class="flex items-center gap-2">
          <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
          <label for="is_active" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <div class="flex justify-end gap-3 border-t pt-6">
          <x-ui.link href="{{ route('admin.teachers.index') }}" variant="secondary" size="md">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Create Instructor
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
