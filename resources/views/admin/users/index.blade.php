@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Users</h1>
        <p class="mt-1 text-sm text-gray-600">Manage all users in your platform</p>
      </div>
      <x-ui.link href="{{ route('admin.users.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New User
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated">
      <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <x-ui.search name="search" placeholder="Search by name or email..." value="{{ request('search') }}" />
        </div>
        <div class="flex gap-2">
          <x-button type="submit" variant="primary" size="md">
            Search
          </x-button>
          @if (request('search'))
            <x-ui.link href="{{ route('admin.users.index') }}" variant="outline" size="md">
              Clear
            </x-ui.link>
          @endif
        </div>
      </form>
    </x-card>

    <!-- Users Table -->
    @if ($users->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Name</x-ui.table-cell>
              <x-ui.table-cell header>Email</x-ui.table-cell>
              <x-ui.table-cell header>Type</x-ui.table-cell>
              <x-ui.table-cell header>Created</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($users as $user)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    <div
                         class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-primary-500 to-secondary-500 text-sm font-bold text-white">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $user->email }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$user->user_type === 'admin' ? 'primary' : 'secondary'" size="sm">
                    {{ ucfirst($user->user_type) }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.users.edit', $user) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                      @csrf
                      @method('DELETE')
                      <x-ui.link href="#" variant="danger" size="sm"
                                 onclick="this.closest('form').submit(); return false;">
                        Delete
                      </x-ui.link>
                    </form>
                  </div>
                </x-ui.table-cell>
              </x-ui.table-row>
            @endforeach
          </x-ui.table-body>
        </x-ui.table>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$users" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No users found" description="Get started by creating a new user." icon="users">
          <x-ui.link href="{{ route('admin.users.create') }}" variant="primary" size="md">
            Add New User
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
