@if ($paginator->hasPages())
    <ul class="theme-pagination">
        {{-- Previous Page Link --}}

        @if ($paginator->onFirstPage())
            <li class="pagination-previous disabled"><span>{{__('previous')}}</span></li>
        @else
            <li class="pagination-previous"><a href="{{ $paginator->previousPageUrl() }}" class="decoration-none"><span>{{__('previous')}}</span></li></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)

            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="current disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="current color-white"><a class="decoration-none  text-white" href="{{ $url }}"><span>{{ $page }}</span></a></li>
                    @else
                        <li><a class="decoration-none" href="{{ $url }}"><span>{{ $page }}</span></a></li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pagination-next"><a class="decoration-none" href="{{ $paginator->nextPageUrl() }}"><span>{{__('next')}}</span></a></li>
        @else
            <li class="pagination-next disabled"><span>{{__('next')}}</span></li>
        @endif

    </ul>
@endif
