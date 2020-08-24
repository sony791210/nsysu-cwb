@if ($paginator->hasPages())
<nav aria-label="Page navigation" class="mt-2 mb-1">
    <ul class="pagination justify-content-end">
        {{-- Previous Page Link --}}
        <li class="page-item {{ PaginateRoute::hasPreviousPage()?'':'disabled'}}">
            <a class="page-link" href="{{ PaginateRoute::hasPreviousPage()?PaginateRoute::previousPageUrl():'#' }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        
{{-- Pagination Elements --}}
@foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
        <li class="page-item disabled"><a class="page-link" href="{{ $url }}">{{ $element }}</a></li>
    @endif

    {{-- Array Of Links --}}
    @if (is_array($element))
        @foreach ($element as $page => $url)
        <li class="page-item {{ $page == $paginator->currentPage()?'active':''}}">
            <a class="page-link" href="{{ $page == $paginator->currentPage()?'':PaginateRoute::pageUrl($page)}}">{{ $page }}</a>
        </li>
        @endforeach
    @endif
@endforeach

        {{-- Next Page Link --}}
        <li class="page-item {{ PaginateRoute::hasNextPage($paginator)?'':'disabled'}}">
            <a class="page-link" href="{{ PaginateRoute::hasNextPage($paginator)?PaginateRoute::nextPageUrl($paginator):'#' }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>
@endif