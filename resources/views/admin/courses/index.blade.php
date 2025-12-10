@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Courses</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your courses</p>
      </div>
      <x-ui.link href="{{ route('admin.courses.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Course
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated">
      <form method="GET" action="{{ route('admin.courses.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <x-ui.search name="search" placeholder="Search by title..." value="{{ request('search') }}" />
        </div>
        <div class="flex gap-2">
          <x-button type="submit" variant="primary" size="md">
            Search
          </x-button>
          @if (request('search'))
            <x-ui.link href="{{ route('admin.courses.index') }}" variant="outline" size="md">
              Clear
            </x-ui.link>
          @endif
        </div>
      </form>
    </x-card>

    <!-- Courses Table -->
    @if ($courses->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Title</x-ui.table-cell>
              <x-ui.table-cell header>Duration</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header>Created</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($courses as $course)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    @if($course->thumbnail)
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="" class="h-10 w-10 rounded-lg object-cover mr-3">
                    @else
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500 mr-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                        <div class="text-xs text-gray-500">{{ Str::limit($course->short_description, 50) }}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $course->duration ?? 'N/A' }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$course->status ? 'success' : 'secondary'" size="sm">
                    {{ $course->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $course->created_at->format('M d, Y') }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.courses.edit', $course) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="delete-form inline">
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
        <x-ui.pagination :paginator="$courses" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No courses found" description="Get started by creating a new course." icon="academic-cap">
          <x-ui.link href="{{ route('admin.courses.create') }}" variant="primary" size="md">
            Add New Course
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
