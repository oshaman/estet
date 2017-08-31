<div class="col-lg-8">
    @if($articles)
        <ul>
            @foreach($articles as $article)
                <li>
                    <div>
                        <p>
                            <img src="{{ asset('/images/article/middle').'/'.$article->image->path }}"
                                 class="img-thumbnail" alt="{{$article->image->alt}}"
                                 title="{{ $article->image->title }}">
                        </p>
                        <span class="label label-default navbar-left">{{ $article->created }}</span>
                        <a href="{{ route('doctors', $article->alias) }}"><h3>{{ $article->title }}</h3></a>
                    </div>
                    <hr>
                </li>
            @endforeach
        </ul>
    @endif
</div>
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