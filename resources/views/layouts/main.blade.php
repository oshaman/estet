<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ $seo_title ??($title ? ($title.' - '. env('APP_NAME')) : env('APP_NAME')) }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/base.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/patient.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css') }}/patient-media.css">
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
<div class="wrapper">
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

    </div>
        @yield('footer')
</div>
<!-- end wraperr -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('js') }}/libs/slick.min.js"></script>
<script src="{{ asset('js') }}/menu.js"></script>
</body>
</html>