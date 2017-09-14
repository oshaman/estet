<aside class="aside">
    <div class="aside-block">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line line-purple"></div>
                <h2>Последние мероприятия</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-vertical">
                @if($lasts)
                    @foreach($lasts as $last)
                        <article>
                            <div class="title-time">
                                <time>
                                    @if(strlen($last->created) < 6) <i class="icons icon-clock"></i> @endif
                                    {{ $last->created }}
                                </time>
                            </div>
                            <a class="link-title" href="{{ route('events', $last->alias) }}">
                                <h3>{{ $last->title }}</h3>
                            </a>
                        </article>
                        @if(0 == $loop->index)
                            <hr> @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="aside-block highly-block">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line line-purple"></div>
                <h2>Самое популярное</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-vertical">
                @if($articles)
                    @foreach($articles as $article)
                        <article>
                            <div class="title-time">
                                <time>
                                    @if(strlen($article->created) < 6) <i class="icons icon-clock"></i> @endif
                                    {{ $article->created }}
                                </time>
                            </div>
                            <a class="link-title" href="{{ route('doctors', $article->alias) }}">
                                <h3>{{ $article->title }}</h3>
                            </a>
                        </article>
                        @if(0 == $loop->index)
                            <hr> @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @include('layouts.horoscope.sidebar')
    <div class="aside-block">
        <div class="advertising">
            {!! $advertising['sidebar'] ?? '<img src="'. asset('estet') .'/img/advertising.jpg" >' !!}
        </div>
    </div>
    <div class="aside-block subscribe-block">
        @include('layouts.subscribe')
    </div>
</aside>













{{--
<div class="row">
    <h3>Последние мероприятия</h3>
    @if($lasts)
        @foreach($lasts as $last)
            <div class="row">
                <p><span class="label label-default">{{ $last->created }}</span></p>
                <p><a href="{{ route('events', $last->alias) }}"> {{ $last->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>
<hr>
<div class="row">
    <h3>Самое популярное</h3>
    @if($articles)
        @foreach($articles as $article)
            <div class="row">
                <p><span class="label label-default">{{ $article->created }}</span></p>
                <p><a href="{{ route('doctors', $article->alias) }}"> {{ $article->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>--}}
