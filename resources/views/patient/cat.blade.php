<div class="col-lg-8">
    @if($articles)
    <ul>
        @foreach($articles as $article)
            <li>
                <a href="{{ route('articles', $article->alias) }}"><h3>{{ $article->title }}</h3></a>
            </li>
        @endforeach
    </ul>
    @endif
</div>
<div class="col-lg-3 col-lg-offset-1">
    @if(!empty($sidebar))
        {!! $sidebar !!}
    @endif
</div>