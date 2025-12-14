@extends('layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Testimonial</h1>
                <p class="mt-1 text-sm text-gray-600">Update testimonial details</p>
            </div>
            <x-ui.link href="{{ route('admin.testimonials.index') }}" variant="default">
                ← Back to List
            </x-ui.link>
        </div>

        <!-- Form -->
        <x-card variant="elevated">
            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <x-forms.input name="name" label="Student Name" :value="old('name', $testimonial->name)" required :error="$errors->first('name')" />
                    <x-forms.input name="role" label="Role / Batch" :value="old('role', $testimonial->role)" required :error="$errors->first('role')" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <select id="rating" name="rating"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                            @foreach(range(5, 1) as $r)
                                <option value="{{ $r }}" {{ old('rating', $testimonial->rating) == $r ? 'selected' : '' }}>{{ $r }} Stars</option>
                            @endforeach
                        </select>
                        <x-forms.error :message="$errors->first('rating')" />
                    </div>
                </div>

                <div>
                    <label for="review" class="block text-sm font-medium text-gray-700 mb-1">Review</label>
                    <textarea id="review" name="review" rows="4" required
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">{{ old('review', $testimonial->review) }}</textarea>
                    <x-forms.error :message="$errors->first('review')" />
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-3">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" id="status" value="1" {{ old('status', $testimonial->status) ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="status" class="text-sm font-medium text-gray-700">Active Status</label>
                </div>

                <!-- Avatar -->
                <div class="space-y-6">
                    @if($testimonial->avatar)
                        <div class="flex items-center gap-4 p-4 border rounded-lg bg-gray-50">
                            <img src="{{ Storage::url($testimonial->avatar) }}" alt="Current Avatar" class="h-16 w-16 rounded-full object-cover">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Current Avatar</p>
                                <p class="text-xs text-gray-500">Upload a new image below to replace it</p>
                            </div>
                        </div>
                    @endif

                    <x-forms.image-uploader name="avatar" label="Avatar" :value="old('avatar')" accept="image/*"
                                            maxSize="2MB" :error="$errors->first('avatar')" />
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-200 pt-6">
                    <x-ui.link href="{{ route('admin.testimonials.index') }}" variant="default">
                        Cancel
                    </x-ui.link>
                    <x-button type="submit" variant="primary" size="md">
                        Update Testimonial
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
