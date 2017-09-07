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
                            <a class="link-title" href="{{ route('blogs', $article->alias) }}">
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
    {!! $horoscope !!}
    <div class="aside-block">
        <div class="advertising">
            {!! $advertising['sidebar'] ?? '<img src="'. asset('estet') .'/img/advertising.jpg" >' !!}
        </div>
    </div>
    <div class="aside-block subscribe-block">
        <div class="form-wrap">
            {!! Form::open(['url'=>route('subscribe')]) !!}
            <h4 class="form-title">Будь в курсе последних новостей</h4>
            <strong>подпишись на рассылку</strong>
            <label>{!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Email', 'id'=>'email', 'class'=>'form-control']) !!}</label>
            <label>
                {!! Form::select('status', [0=>'Пациент', 1=>'Доктор'],
                    old('status') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Доктор\Пациент'])
                !!}
            </label>
            <button class="pod-subs pod-purpur" type="button">Подписаться</button>
            {!! Form::close() !!}
        </div>
    </div>
</aside>