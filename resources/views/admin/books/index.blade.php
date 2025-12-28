@extends('layouts.admin')

@section('content')
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Books</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your books</p>
      </div>
      <x-ui.link href="{{ route('admin.books.create') }}" variant="primary" size="md">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add New Book
      </x-ui.link>
    </div>

    <!-- Search and Filters -->
    <x-card variant="elevated">
      <form method="GET" action="{{ route('admin.books.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
        <div class="flex-1">
          <x-ui.search name="search" placeholder="Search by title or author..." value="{{ request('search') }}" />
        </div>
        <div class="flex gap-2">
          <x-button type="submit" variant="primary" size="md">
            Search
          </x-button>
          @if (request('search'))
            <x-ui.link href="{{ route('admin.books.index') }}" variant="outline" size="md">
              Clear
            </x-ui.link>
          @endif
        </div>
      </form>
    </x-card>

    <!-- Books Table -->
    @if ($books->count() > 0)
      <x-card variant="elevated">
        <x-ui.table>
          <x-ui.table-head>
            <x-ui.table-row>
              <x-ui.table-cell header>Title</x-ui.table-cell>
              <x-ui.table-cell header>Author</x-ui.table-cell>
              <x-ui.table-cell header>Preview Images</x-ui.table-cell>
              <x-ui.table-cell header>Price</x-ui.table-cell>
              <x-ui.table-cell header>Discount</x-ui.table-cell>
              <x-ui.table-cell header>Stock</x-ui.table-cell>
              <x-ui.table-cell header>Status</x-ui.table-cell>
              <x-ui.table-cell header class="text-right">Actions</x-ui.table-cell>
            </x-ui.table-row>
          </x-ui.table-head>
          <x-ui.table-body>
            @foreach ($books as $book)
              <x-ui.table-row>
                <x-ui.table-cell>
                  <div class="flex items-center">
                    @if ($book->cover_image)
                      <img src="{{ Storage::url($book->cover_image) }}" alt=""
                           class="mr-3 h-10 w-10 rounded-lg object-cover">
                    @else
                      <div
                           class="mr-3 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                          </path>
                        </svg>
                      </div>
                    @endif
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ $book->title }}</div>
                      <div class="text-xs text-gray-500">{!! Str::limit($book->short_description, 50) !!}</div>
                    </div>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">{{ $book->author }}</div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  @if ($book->preview_images && is_array($book->preview_images) && count($book->preview_images) > 0)
                    <div class="flex -space-x-2">
                      @foreach (array_slice($book->preview_images, 0, 3) as $previewImage)
                        <img src="{{ Storage::url($previewImage) }}" alt="Preview"
                             class="h-10 w-10 cursor-pointer rounded-lg border-2 border-white object-cover transition-transform hover:z-10 hover:scale-110"
                             title="Preview Image">
                      @endforeach
                      @if (count($book->preview_images) > 3)
                        <div
                             class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-white bg-gray-100 text-xs font-medium text-gray-600">
                          +{{ count($book->preview_images) - 3 }}
                        </div>
                      @endif
                    </div>
                  @else
                    <span class="text-xs text-gray-400">No preview images</span>
                  @endif
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">
                    @if ($book->discount > 0 && $book->price)
                      <div>
                        <span class="text-gray-400 line-through">{{ format_price($book->price) }}</span>
                        <span
                              class="ml-2 font-semibold text-primary-600">{{ format_price($book->discounted_price) }}</span>
                      </div>
                    @elseif ($book->price)
                      <span class="font-medium">{{ format_price($book->price) }}</span>
                    @else
                      <span class="text-gray-400">Not set</span>
                    @endif
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">
                    @if ($book->discount > 0)
                      <span class="rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-700">
                        -{{ number_format($book->discount, 0) }}%
                      </span>
                    @else
                      <span class="text-gray-400">—</span>
                    @endif
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <div class="text-sm text-gray-900">
                    <span
                          class="{{ $book->stock_quantity > 0 ? 'font-semibold text-green-600' : 'font-semibold text-red-600' }}">
                      {{ $book->stock_quantity ?? 0 }}
                    </span>
                  </div>
                </x-ui.table-cell>
                <x-ui.table-cell>
                  <x-ui.badge :variant="$book->status ? 'success' : 'secondary'" size="sm">
                    {{ $book->status ? 'Active' : 'Inactive' }}
                  </x-ui.badge>
                </x-ui.table-cell>
                <x-ui.table-cell class="text-right">
                  <div class="flex items-center justify-end gap-2">
                    <x-ui.link href="{{ route('admin.books.edit', $book) }}" variant="outline" size="sm">
                      Edit
                    </x-ui.link>
                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="delete-form inline">
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
        <x-ui.pagination :paginator="$books" />
      </x-card>
    @else
      <x-card variant="elevated">
        <x-ui.empty-state title="No books found" description="Get started by creating a new book." icon="academic-cap">
          <x-ui.link href="{{ route('admin.books.create') }}" variant="primary" size="md">
            Add New Book
          </x-ui.link>
        </x-ui.empty-state>
      </x-card>
    @endif
  </div>
@endsection
