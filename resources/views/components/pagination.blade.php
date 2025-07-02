@if ($paginator->hasPages())
    <nav class="inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="@lang('pagination.previous')"
                class="px-3 py-1 bg-gray-200 rounded-l cursor-default select-none">«</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-l" aria-label="@lang('pagination.previous')">«</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span aria-disabled="true"
                    class="px-3 py-1 bg-gray-200 cursor-default select-none">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page"
                            class="px-3 py-1 bg-blue-500 text-white cursor-default select-none">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-r" aria-label="@lang('pagination.next')">»</a>
        @else
            <span aria-disabled="true" aria-label="@lang('pagination.next')"
                class="px-3 py-1 bg-gray-200 rounded-r cursor-default select-none">»</span>
        @endif
    </nav>
@endif
