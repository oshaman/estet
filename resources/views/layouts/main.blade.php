<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($seo->seo_keywords))
        <meta name="keywords" content="{{ $seo->seo_keywords }}">
    @endif
    @if(!empty($seo->seo_description))
        <meta name="description" content="{{ $seo->seo_description }}">
    @endif
    @if(!empty($seo->og_title))
        <meta property="og:title" content="{{ $seo->og_title }}"/>
    @endif
    @if(!empty($seo->og_description))
        <meta property="og:description" content="{{ $seo->og_description }}"/>
    @endif
    <meta property="og:url" content="{{ url()->current() }}"/>
    @if(!empty($seo->og_image))
        <meta property="og:image" content="{{ $seo->og_image }}"/>
    @endif
    <title>{{ $seo->seo_title ??($title ? ($title.' - '. env('APP_NAME')) : env('APP_NAME')) }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/base.css">
    @if(!empty($css))
        {!! $css !!}
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/fonts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/menu.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Vidaloka" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:400,600i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:700&amp;subset=cyrillic,cyrillic-ext,latin-ext,vietnamese"
            rel="stylesheet">
</head>
<body>
@if(session()->has('doc'))
    <div class="wrapper doctor-page
    @if((Route::currentRouteName() ==  'blogs'))
        blog-page
    @endif
    ">
@else
    <div class="wrapper">
@endif
    <div class="w-block"></div>
    <!--menu mobal-->
    <header>
        <div class="container-fool">
            <div class="container">
                @yield('navbar')
            </div>
        </div>
    </header>
    <div class="container">
        @if(!empty($title_img))
            <h1><img src="{{ asset('estet') }}/img/title.png" alt="{{ env('APP_NAME') }}" title="{{ env('APP_NAME') }}"></h1>
        @endif

        @yield('content')

        <div class="wrap-top-top">
            <div class="to-top"></div>
            наверх
        </div>

    </div>
        @yield('footer')
</div>
            <!--pop-->
            <div class="wrap-pop">
                <div class="pop-bg"></div>
                <div class="pop-up to-page-doctor">
                    <div class="pop-inner">
                        <div class="close-pop">X</div>
                        {{--temp--}}
                        @if(!session()->has('doc'))
                            {!! Form::open(['url' => route('switch'), 'method'=>'POST']) !!}
                            {!! Form::hidden('doc', true) !!}
                            {!! Form::button(trans('ru.doctor'), ['class' => 'btn btn-success','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['url' => route('switch'), 'method'=>'POST']) !!}
                            {!! Form::hidden('patient', true) !!}
                            {!! Form::button(trans('ru.patient'), ['class' => 'btn btn-info','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        @endif
                        {{--temp--}}
                    </div>
                </div>
            </div>
            <!--end pop-->
<!-- end wraperr -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('js') }}/libs/slick.min.js"></script>
<script src="{{ asset('js') }}/menu.js"></script>
            @if(!empty($js))
                {!! $js !!}
            @endif
            <script src="{{ asset('js') }}/animations.js"></script>
</body>
</html>