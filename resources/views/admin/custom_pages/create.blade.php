@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Add New Page</h1>
        <p class="mt-1 text-sm text-gray-600">Create a new custom page.</p>
      </div>
      <x-ui.link href="{{ route('admin.custom-pages.index') }}" variant="outline" size="sm">
        Back to Pages
      </x-ui.link>
    </div>

    <form action="{{ route('admin.custom-pages.store') }}" method="POST">
      @csrf

      <x-card variant="elevated" class="max-w-8xl">
        <div class="space-y-6">
          
          <div>
            <x-forms.input label="Page Title" type="text" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Privacy Policy" required :error="$errors->first('title')" />
          </div>

          <div>
            <x-forms.rich-text name="content" label="Content" :value="old('content')" :error="$errors->first('content')" required />
          </div>

          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <x-forms.input label="Meta Title" type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO Meta Title" :error="$errors->first('meta_title')" />
            </div>
            <div>
                <x-forms.input label="Meta Description" type="text" id="meta_description" name="meta_description" value="{{ old('meta_description') }}" placeholder="SEO Meta Description" :error="$errors->first('meta_description')" />
            </div>
          </div>

          <div class="flex items-center gap-2">
            <input type="checkbox" id="is_active" name="is_active" value="1" class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500" {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
            @error('is_active')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex justify-end gap-3 pt-4 border-t">
            <x-ui.link href="{{ route('admin.custom-pages.index') }}" variant="outline" size="md">
              Cancel
            </x-ui.link>
            <x-button type="submit" variant="primary" size="md">
              Save Page
            </x-button>
          </div>
        </div>
      </x-card>
    </form>
  </div>

@endsection
