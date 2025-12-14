@extends('layouts.admin')

@section('title', 'Add Testimonial')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add New Testimonial</h1>
                <p class="mt-1 text-sm text-gray-600">Add a new student feedback</p>
            </div>
            <x-ui.link href="{{ route('admin.testimonials.index') }}" variant="default">
                ← Back to List
            </x-ui.link>
        </div>

        <!-- Form -->
        <x-card variant="elevated">
            <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <x-forms.input name="name" label="Student Name" :value="old('name')" required :error="$errors->first('name')" />
                    <x-forms.input name="role" label="Role / Batch" :value="old('role')" required :error="$errors->first('role')" placeholder="e.g. Student, Batch 25" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                         <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                         <select id="rating" name="rating"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @foreach(range(5, 1) as $r)
                                <option value="{{ $r }}" {{ old('rating', 5) == $r ? 'selected' : '' }}>{{ $r }} Stars</option>
                            @endforeach
                        </select>
                        <x-forms.error :message="$errors->first('rating')" />
                    </div>
                </div>

                <div>
                    <!-- Using standard textarea standard layout for simplicity as standard x-forms.textarea wasn't explicitly seen, but standardizing style -->
                    <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                    <textarea id="review" name="review" rows="4" required
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('review') }}</textarea>
                    <x-forms.error :message="$errors->first('review')" />
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-3">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" id="status" value="1" {{ old('status', 1) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
                </div>

                <!-- Avatar -->
                <div class="space-y-6">
                    <x-forms.image-uploader name="avatar" label="Avatar" :value="old('avatar')" accept="image/*"
                                            maxSize="2MB" :error="$errors->first('avatar')" />
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
                    <x-ui.link href="{{ route('admin.testimonials.index') }}" variant="default">
                        Cancel
                    </x-ui.link>
                    <x-button type="submit" variant="primary" size="md">
                        Save Testimonial
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
