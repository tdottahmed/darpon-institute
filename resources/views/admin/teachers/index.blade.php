@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Teachers</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your teachers</p>
      </div>
      <x-ui.link href="{{ route('admin.teachers.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Teacher
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated">
      <form method="GET" action="{{ route('admin.teachers.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <x-ui.search name="search" placeholder="Search by name, designation or department..." value="{{ request('search') }}" />
        </div>
        <div class="flex gap-2">
          <x-button type="submit" variant="primary" size="md">
            Search
          </x-button>
          @if (request('search'))
            <x-ui.link href="{{ route('admin.teachers.index') }}" variant="outline" size="md">
              Clear
            </x-ui.link>
          @endif
        </div>
      </form>
    </x-card>

    <!-- Teachers Table -->
    @if ($teachers->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Teacher</x-ui.table-cell>
              <x-ui.table-cell header>Designation</x-ui.table-cell>
              <x-ui.table-cell header>Department</x-ui.table-cell>
              <x-ui.table-cell header>Order</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($teachers as $teacher)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    @if ($teacher->image_path)
                      <img src="{{ Storage::url($teacher->image_path) }}" alt=""
                           class="mr-3 h-10 w-10 rounded-full object-cover">
                    @else
                      <div
                           class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                          </path>
                        </svg>
                      </div>
                    @endif
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $teacher->designation }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $teacher->department }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $teacher->order }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$teacher->is_active ? 'success' : 'secondary'" size="sm">
                    {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.teachers.edit', $teacher) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="delete-form inline">
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
        <x-ui.pagination :paginator="$teachers" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No teachers found" description="Get started by adding a new teacher." icon="users">
          <x-ui.link href="{{ route('admin.teachers.create') }}" variant="primary" size="md">
            Add New Teacher
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
