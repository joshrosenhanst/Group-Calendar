@if ($paginator->hasPages())
  <nav class="pagination" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
          <li >
            <a class="pagination-previous" aria-disabled="true" aria-label="@lang('pagination.previous')" disabled>@materialicon('chevron-left')</a>
          </li>
        @else
          <li>
            <a class="pagination-previous" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">@materialicon('chevron-left')</a>
          </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
            <li >
              <span class="pagination-ellipsis" aria-disabled="true">{{ $element }}</span>
            </li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li>
                  <span class="pagination-link is-current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
                </li>
              @else
                <li>
                  <a class="pagination-link" href="{{ $url }}" aria-label="Go to Page {{ $page }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
          <li>
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">@materialicon('chevron-right')</a>
          </li>
        @else
          <li>
            <a class="pagination-next" aria-hidden="true" aria-disabled="true" aria-label="@lang('pagination.next')" disabled>@materialicon('chevron-right')</a>
          </li>
        @endif
    </ul>
  </nav>
@endif
