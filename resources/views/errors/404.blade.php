@extends('/../layouts/main')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (isset($errors) && count($errors) > 0)
                    <div class="contact-form">
                        <p class="error">

                            {{ dump($errors)  }}
                        </p>
                    </div>
                @endif
                @if (session('status'))
                    <div  class="alert alert-success">
                        <p class="success">{{ session('status') }}</p>
                    </div>
                @endif

                    <img src="{{ asset('estet') . '/img/404.png' }}" class=".img-thumbnail">
                <h2>Вы потерялись</h2>
                <hr>
                <h3>----------------- Интересный факт № {{ $article->id }} -----------------</h3>
                <div class="row">
                    <div class="col-lg-3">
                        <img src="{{ asset('/images/article/middle').'/'.$article->path }}"
                             class="img-thumbnail" alt="{{$article->alt}}" title="{{ $article->img_title }}">
                    </div>
                    <div class="col-lg-8 col-lg-offset-1">
                        <h3>{{ $article->title }}</h3>
                        <p>{!! $article->content !!}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">Рекомендуем почитать</div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4">Или вернуться</div>
                </div>
                <div class="row">
                    <div class="col-lg-4"><a class="btn btn-info" href="{{ route('articles_last') }}">
                            Последние статьи
                        </a>
                    </div>
                    <div class="col-lg-4">----------------------------------</div>
                    <div class="col-lg-4">
                        <a class="btn btn-info" href="{{ route('main') }}">
                            На главную страницу
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    {!! $footer !!}
@endsection