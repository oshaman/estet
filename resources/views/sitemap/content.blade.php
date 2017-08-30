<div class="row bg-success">
    <div class="row"><h2><a href="{{ route('main') }}">Главная</a></h2></div>
    <div class="row">
        @if(!empty($vars['cats']))
            @foreach($vars['cats'] as $cat)
                <div class="row">
                    @if('patient' === $cat->own)
                        <h3><a href="{{ route('article_cat', $cat->alias) }}">{{ $cat->name }}</a></h3>
                        @if(!empty($vars['p_articles']))
                            <ul>
                                @foreach($vars['p_articles'] as $article)
                                    @if ($cat->id != $article->category_id)
                                        @continue
                                    @endif
                                    <li><a href="{{ route('articles', $article->alias) }}">{{ $article->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <h3><a href="{{ route('docs_cat', $cat->alias) }}">{{ $cat->name }}</a></h3>
                        @if(!empty($vars['d_articles']))
                            <ul>
                                @foreach($vars['d_articles'] as $article)
                                    @if ($cat->id != $article->category_id)
                                        @continue
                                    @endif
                                    <li><a href="{{ route('doctors', $article->alias) }}">{{ $article->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>