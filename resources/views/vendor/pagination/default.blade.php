@if($paginator->hasPages())
    @if ($paginator->onFirstPage())
        {{--<span>&laquo;</span>--}}
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="laypage-curr">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="laypage-curr">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a>
    @else
        {{--<span>&raquo;</span>--}}
    @endif
@endif