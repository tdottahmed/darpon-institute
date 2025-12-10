@props(['paginator'])

@if ($paginator->hasPages())
  <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      @if ($paginator->onFirstPage())
        <span
              class="relative inline-flex cursor-not-allowed items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500">
          Previous
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
          Previous
        </a>
      @endif

      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
          Next
        </a>
      @else
        <span
              class="relative ml-3 inline-flex cursor-not-allowed items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500">
          Next
        </span>
      @endif
    </div>

    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ $paginator->firstItem() }}</span>
          to
          <span class="font-medium">{{ $paginator->lastItem() }}</span>
          of
          <span class="font-medium">{{ $paginator->total() }}</span>
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          @if ($paginator->onFirstPage())
            <span
                  class="relative inline-flex cursor-not-allowed items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500">
              <span class="sr-only">Previous</span>
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
              </svg>
            </span>
          @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
              <span class="sr-only">Previous</span>
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
              </svg>
            </a>
          @endif

          @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            $startPage = max(1, $currentPage - 2);
            $endPage = min($lastPage, $currentPage + 2);
          @endphp

          @if ($startPage > 1)
            <a href="{{ $paginator->url(1) }}"
               class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
              1
            </a>
            @if ($startPage > 2)
              <span
                    class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">
                ...
              </span>
            @endif
          @endif

          @foreach ($paginator->getUrlRange($startPage, $endPage) as $page => $url)
            @if ($page == $paginator->currentPage())
              <span aria-current="page"
                    class="relative z-10 inline-flex items-center border border-primary-500 bg-primary-50 px-4 py-2 text-sm font-medium text-primary-600">
                {{ $page }}
              </span>
            @else
              <a href="{{ $url }}"
                 class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                {{ $page }}
              </a>
            @endif
          @endforeach

          @if ($endPage < $lastPage)
            @if ($endPage < $lastPage - 1)
              <span
                    class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">
                ...
              </span>
            @endif
            <a href="{{ $paginator->url($lastPage) }}"
               class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
              {{ $lastPage }}
            </a>
          @endif

          @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
              <span class="sr-only">Next</span>
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd" />
              </svg>
            </a>
          @else
            <span
                  class="relative inline-flex cursor-not-allowed items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500">
              <span class="sr-only">Next</span>
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd" />
              </svg>
            </span>
          @endif
        </nav>
      </div>
    </div>
  </div>
@endif
