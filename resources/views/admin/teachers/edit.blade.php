@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Teacher</h1>
        <p class="mt-1 text-sm text-gray-600">Update teacher profile</p>
      </div>
      <x-ui.link href="{{ route('admin.teachers.index') }}" variant="secondary" size="md">
        Back to List
      </x-ui.link>
    </div>

    <x-card variant="elevated">
      <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <!-- Name -->
          <div>
            <x-forms.input label="Name" type="text" name="name" id="name" value="{{ old('name', $teacher->name) }}" required :error="$errors->first('name')" />
          </div>

          <!-- Designation -->
          <div>
            <x-forms.input label="Designation" type="text" name="designation" id="designation" value="{{ old('designation', $teacher->designation) }}" required :error="$errors->first('designation')" />
          </div>

          <!-- Department -->
          <div>
            <x-forms.input label="Department" type="text" name="department" id="department" value="{{ old('department', $teacher->department) }}" required :error="$errors->first('department')" />
          </div>

          <!-- Order -->
          <div>
            <x-forms.input label="Display Order" type="number" name="order" id="order" value="{{ old('order', $teacher->order) }}" required min="0" :error="$errors->first('order')" />
          </div>
        </div>

        <!-- Image -->
        <div>
          <x-forms.label for="image">Profile Image</x-forms.label>
          @if($teacher->image_path)
            <div class="mb-2">
              <img src="{{ Storage::url($teacher->image_path) }}" alt="Current Image" class="h-20 w-20 rounded object-cover border">
            </div>
          @endif
          <input type="file" name="image" id="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" accept="image/*">
          <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image.</p>
          <x-forms.error :message="$errors->first('image')" />
        </div>

        <!-- Status -->
        <div class="flex items-center gap-2">
          <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-600">
          <label for="is_active" class="text-sm font-medium text-gray-700">Active Status</label>
        </div>

        <div class="flex justify-end gap-3 border-t pt-6">
          <x-ui.link href="{{ route('admin.teachers.index') }}" variant="secondary" size="md">
            Cancel
          </x-ui.link>
          <x-button type="submit" variant="primary" size="md">
            Update Teacher
          </x-button>
        </div>
      </form>
    </x-card>
  </div>
@endsection
