@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Video Blogs</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your video blogs</p>
      </div>
      <x-ui.link href="{{ route('admin.video-blogs.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Video Blog
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated">
      <form method="GET" action="{{ route('admin.video-blogs.index') }}"
            class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <x-ui.search name="search" placeholder="Search by title..." value="{{ request('search') }}" />
        </div>
        <div class="flex gap-2">
          <x-button type="submit" variant="primary" size="md">
            Search
          </x-button>
          @if (request('search'))
            <x-ui.link href="{{ route('admin.video-blogs.index') }}" variant="outline" size="md">
              Clear
            </x-ui.link>
          @endif
        </div>
      </form>
    </x-card>

    <!-- Video Blogs Table -->
    @if ($videoBlogs->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Title</x-ui.table-cell>
              <x-ui.table-cell header>Type</x-ui.table-cell>
              <x-ui.table-cell header>Video</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($videoBlogs as $videoBlog)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    @if ($videoBlog->thumbnail)
                      <img src="{{ Storage::url($videoBlog->thumbnail) }}" alt=""
                           class="mr-3 h-10 w-10 rounded-lg object-cover">
                    @else
                      <div
                           class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                          </path>
                        </svg>
                      </div>
                    @endif
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ $videoBlog->title }}</div>
                      <div class="text-xs text-gray-500">{{ Str::limit($videoBlog->short_description, 50) }}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($videoBlog->video_type === 'youtube')
                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                      YouTube
                    </span>
                  @else
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                      Upload
                    </span>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                    @if($videoBlog->video_type === 'youtube' && $videoBlog->video_url)
                        <a href="{{ $videoBlog->video_url }}" target="_blank" class="text-primary-600 hover:text-primary-900 text-sm">Valid Link</a>
                    @elseif($videoBlog->video_type === 'upload' && $videoBlog->video_file)
                        <a href="{{ Storage::url($videoBlog->video_file) }}" target="_blank" class="text-primary-600 hover:text-primary-900 text-sm">View File</a>
                    @else
                        <span class="text-gray-400 text-sm">No Video</span>
                    @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$videoBlog->status ? 'success' : 'secondary'" size="sm">
                    {{ $videoBlog->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.video-blogs.edit', $videoBlog) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.video-blogs.destroy', $videoBlog) }}" method="POST"
                          class="delete-form inline">
                      @csrf
                      @method('DELETE')
                      <button type="button"
                              class="delete-confirm inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Delete
                      </button>
                    </form>
                  </div>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$videoBlogs" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No video blogs found" description="Get started by creating a new video blog."
                          icon="video-camera">
          <x-ui.link href="{{ route('admin.video-blogs.create') }}" variant="primary" size="md">
            Add New Video Blog
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
