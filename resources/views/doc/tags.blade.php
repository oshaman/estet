@if($articles)
    <ul class="list-group">
    @foreach($articles as $artile)
        <li class="list-group-item">
            <a href="{{ route('doctors', $artile->alias) }}"><h3>{{ $artile->title }}</h3></a>
        </li>
    @endforeach
    </ul>
@endif
<!--PAGINATION-->
<div class="general-pagination group">
    @if($articles->lastPage() > 1)
        <ul class="pagination">
            @if($articles->currentPage() !== 1)
                <li>
                    <a href="{{ $articles->url(($articles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a>
                </li>
            @endif

            @for($i = 1; $i <= $articles->lastPage(); $i++)
                @if($articles->currentPage() == $i)
                    <li><a class="active disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($articles->currentPage() !== $articles->lastPage())
                <li>
                    <a href="{{ $articles->url(($articles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a>
                </li>
            @endif
        </ul>
    @endif
</div>