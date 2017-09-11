@extends('/../layouts/main')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    <div class="content-404">
        <div class="content-block">
            <p>4 0 4</p>
            <span>Вы потерялись</span>

            <div class="search-404">

                <input type="search" name="q" placeholder="найти на сайте">
                <div class="search" id="search">
                    <img src="{{ asset('estet') }}/img/menu/search.png">
                </div>
            </div>
            <div class="fakt-404" >
                <span>Интересный факт №{{ $article->id }}</span>
            </div>
            <div class="flex-item-container">
                <div class="flex-item">
                    <img src="{{ asset('/images/article/middle').'/'.$article->path }}"
                         alt="{{$article->alt}}" title="{{ $article->img_title }}">
                </div>
                <div class="flex-item">
                    <p>{{ $article->title }}</p>
                    <span>{!! str_limit(strip_tags($article->content), 512) !!}</span>
                </div>

            </div>
            <div class="flex-bitum">
                <div class="flex-404">
                    <p>Рекомендуем почитать</p>
                    <a href="{{ route('articles_last') }}"><button>Последние статьи</button></a>

                </div>
                <div class="flex-404"><hr></div>
                <div class="flex-404">
                    <p>Или вернуться</p>
                    <a href="{{ route('main') }}"><button>На главною станицю</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {!! $footer !!}
@endsection