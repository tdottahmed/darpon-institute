@extends('layouts.admin')

@section('title', 'Manage Testimonials')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Testimonials</h1>
                <p class="mt-1 text-sm text-gray-600">Manage student testimonials</p>
            </div>
            <x-ui.link href="{{ route('admin.testimonials.create') }}" variant="primary" size="md">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Testimonial
            </x-ui.link>
        </div>

        <!-- Search and Filters -->
        <x-card variant="elevated">
            <form method="GET" action="{{ route('admin.testimonials.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                <div class="flex-1">
                    <x-ui.search name="search" placeholder="Search by name or role..." value="{{ request('search') }}" />
                </div>
                <div class="flex gap-2">
                    <x-button type="submit" variant="primary" size="md">
                        Search
                    </x-button>
                    @if (request('search'))
                        <x-ui.link href="{{ route('admin.testimonials.index') }}" variant="outline" size="md">
                            Clear
                        </x-ui.link>
                    @endif
                </div>
            </form>
        </x-card>

        <!-- Testimonials Table -->
        @if ($testimonials->count() > 0)
            <x-card variant="elevated">
                <x-ui.table>
                    <x-ui.table-head>
                        <x-ui.table-row>
                            <x-ui.table-cell header>Student</x-ui.table-cell>
                            <x-ui.table-cell header>Role</x-ui.table-cell>
                            <x-ui.table-cell header>Rating</x-ui.table-cell>
                            <x-ui.table-cell header>Status</x-ui.table-cell>
                            <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
                        </x-ui.table-row>
                    </x-ui.table-head>
                    <x-ui.table-body>
                        @foreach ($testimonials as $testimonial)
                            <x-ui.table-row>
                                <x-ui.table-cell>
                                    <div class="flex items-center">
                                        @if ($testimonial->avatar)
                                            <img src="{{ Storage::url($testimonial->avatar) }}" alt=""
                                                 class="mr-3 h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-primary-600 font-bold">
                                                {{ substr($testimonial->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="font-medium text-gray-900">{{ $testimonial->name }}</div>
                                    </div>
                                </x-ui.table-cell>
                                <x-ui.table-cell>
                                    <div class="text-sm text-gray-500">{{ $testimonial->role }}</div>
                                </x-ui.table-cell>
                                <x-ui.table-cell>
                                    <div class="flex text-yellow-400">
                                        @for($i = 0; $i < $testimonial->rating; $i++)
                                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </x-ui.table-cell>
                                <x-ui.table-cell>
                                    <x-ui.badge :variant="$testimonial->status ? 'success' : 'secondary'" size="sm">
                                        {{ $testimonial->status ? 'Active' : 'Inactive' }}
                                    </x-ui.badge>
                                </x-ui.table-cell>
                                <x-ui.table-cell class="text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-ui.link href="{{ route('admin.testimonials.edit', $testimonial) }}" variant="outline" size="sm">
                                            Edit
                                        </x-ui.link>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="delete-form inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-red-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
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
                <x-ui.pagination :paginator="$testimonials" />
            </x-card>
        @else
            <x-card variant="elevated">
                <x-ui.empty-state title="No testimonials found" description="Get started by creating a new testimonial." icon="user-group">
                    <x-ui.link href="{{ route('admin.testimonials.create') }}" variant="primary" size="md">
                        Add Testimonial
                    </x-ui.link>
                </x-ui.empty-state>
            </x-card>
        @endif
    </div>
@endsection
