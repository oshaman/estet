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
    <link
            href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:700&amp;subset=cyrillic,cyrillic-ext,latin-ext,vietnamese"
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
            <h1><img src="{{ asset('estet') }}/img/title.png" alt=""></h1>
        @endif

        @yield('content')

    </div>
    <footer>
        <div class="footer-top">
            <div class="left">
                <h2 class="footer-header"><img src="{{ asset('estet') }}/img/footer/logo.png"></h2>
                <div class="social">
                    <div class="winget">
                        <p>мы в соц. сетях</p>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/fb.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/yt.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/tw.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/vk.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/oc.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/gp.png" hspace="10" vspace="5"></a>
                        <a href="#"><img src="{{ asset('estet') }}/img/footer/ig.png" hspace="10" vspace="5"></a>
                    </div>
                </div>
            </div>
            <div class="center">
                <p>Все материалы созданы и подготовлены для некоммерческих и образовательных целей посетителей Портала.
                    Мнение
                    редакции не всегда совпадает с мнением авторов. При цитировании или копировании любой информации
                    обязательно
                    должна быть указана ссылка на estet-portal.com как источник.</p>
                <p>© 2011–2017 Все права защищены. За материалы, предоставленные на правах рекламы, ответственность
                    несёт
                    рекламодатель. Запрещается копирование статей и других объектов права интеллектуальной собственности
                    сайта
                    www.estet-portal.com без указания прямой, видимой и индексируемой поисковыми системами ссылки
                    непосредственно
                    над или под источником контента.</p>
            </div>
            <div class="right">
                <div class="advertising">
                    <img src="{{ asset('estet') }}/img/footer/Rectangle 1125.png">
                </div>
            </div>
        </div>
        <div class="footer-bot">
            <div class="left">
                <a href=""><img src="{{ asset('estet') }}/img/footer/app.png"></a>
            </div>
            <div class="center">
                <div class="footer-menu">
                    <div>
                        <a href="#">О ПРОЕКТЕ</a>
                        <a href="#">РЕКЛАМА</a>
                        <a href="#">ОБРАТНАЯ СВЯЗЬ</a>
                        <a href="#">КАРТА САЙТА</a>
                        <a href="#">RSS</a>
                    </div>
                    <div>
                        <a href="#">СОГЛАШЕНИЕ ОБ ИСПОЛЬЗОВАНИИ</a>
                        <a href="#">ПАРТНЕРСТВО</a>
                        <a href="#">ВИДЕО ОТЗЫВЫ</a>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="partner">
                    <a target="_blank" href="https://econet.ua/">
                        <span>партнер</span>
                        <span>ECONET</span>
                    </a>
                </div>
                <div class="developing">
                    <a target="_blank" href="https://freshweb.agency?utm_source=ESTET-PORTAL">
                        <span>разработка</span>
                        <span>FRESH</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- end wraperr -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('js') }}/libs/slick.min.js"></script>
<script src="{{ asset('js') }}/menu.js"></script>
</body>
</html>