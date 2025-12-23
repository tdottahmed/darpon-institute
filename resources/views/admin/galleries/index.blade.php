@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Image Gallery</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your gallery images</p>
      </div>
      <x-ui.link href="{{ route('admin.galleries.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Upload Images
      </x-ui.link>
    </div>

    <!-- Gallery Grid -->
    @if ($galleries->count() > 0)
      <x-card variant="elevated">
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
          @foreach ($galleries as $gallery)
            <div
                 class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800">
              <!-- Image -->
              <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-900">
                <img src="{{ Storage::url($gallery->image) }}" alt="Gallery Image"
                     class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                <!-- Status Badge -->
                <div class="absolute right-2 top-2">
                  <x-ui.badge :variant="$gallery->status ? 'success' : 'secondary'" size="sm">
                    {{ $gallery->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </div>
                <!-- Order Badge -->
                @if ($gallery->order > 0)
                  <div class="absolute left-2 top-2">
                    <span
                          class="inline-flex items-center rounded-full bg-black/60 px-2 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                      #{{ $gallery->order }}
                    </span>
                  </div>
                @endif
              </div>

              <!-- Actions -->
              <div class="p-3">
                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="button"
                          class="delete-confirm inline-flex w-full items-center justify-center rounded-lg border border-red-200 bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Delete
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$galleries" class="mt-6" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No gallery images found" description="Get started by uploading images to the gallery."
                          icon="photograph">
          <x-ui.link href="{{ route('admin.galleries.create') }}" variant="primary" size="md">
            Upload Images
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
