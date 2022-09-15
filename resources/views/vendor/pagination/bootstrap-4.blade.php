@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())

            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="prev page-numbers"><i class='bx bx-chevron-left'></i></a>
                &nbsp; &nbsp;
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="" ><a class="page-numbers current" href="{{ $url }}" aria-current="page">{{ $page }}</a></li>
                        @else
                            <li class=""><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                &nbsp; &nbsp;
                <a href="{{ $paginator->nextPageUrl() }}" class="next page-numbers"><i class='bx bx-chevron-right'></i></a>
            @else

            @endif
        </ul>
    </nav>
@endif