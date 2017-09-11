<footer>
    <div class="footer-top">
        <div class="left">
            <h2 class="footer-head"><img src="{{ asset('estet') }}/img/footer/logo.png"></h2>
            <div class="social-wrap">
                <h5>мы в соц. сетях</h5>
                <div class="social">
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/fb.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/yt.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/tw.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/vk.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/oc.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/gp.png"></a>
                    <a href="#"><img src="{{ asset('estet') }}/img/footer/lg/ig.png"></a>
                </div>
            </div>
        </div>
        <div class="center">
            <p>Все материалы созданы и подготовлены для некоммерческих и образовательных целей посетителей Портала.
                Мнение
                редакции не всегда совпадает с мнением авторов. При цитировании или копировании любой информации
                обязательно
                должна быть указана ссылка на estet-portal.com как источник.</p>
            <p>© 2011–2017 Все права защищены. За материалы, предоставленные на правах рекламы, ответственность несёт
                рекламодатель. Запрещается копирование статей и других объектов права интеллектуальной собственности
                сайта
                www.estet-portal.com без указания прямой, видимой и индексируемой поисковыми системами ссылки
                непосредственно
                над или под источником контента.</p>
        </div>
        <div class="right">
            <div class="footer-ad">
                <img src="{{ asset('estet') }}/img/footer/Rectangle 1125.png">
            </div>
        </div>
    </div>
    <div class="footer-bot">
        <div class="left">
            <a href=""><img class="app-store" src="{{ asset('estet') }}/img/footer/app.png"></a>
        </div>
        <div class="center">
            <div class="footer-menu">
                <div>
                    @if('about' !== Route::currentRouteName()) <a href="{{ route('about') }}">О ПРОЕКТЕ</a> @endif
                    @if('advertising' !== Route::currentRouteName()) <a
                            href="{{ route('advertising') }}">РЕКЛАМА</a> @endif
                    @if('contacts' !== Route::currentRouteName()) <a href="{{ route('contacts') }}">ОБРАТНАЯ
                        СВЯЗЬ</a> @endif
                    @if('sitemap' !== Route::currentRouteName()) <a href="{{ route('sitemap') }}">КАРТА САЙТА</a> @endif
                    @if('rss' !== Route::currentRouteName()) <a href="#">RSS</a> @endif
                </div>
                <div>
                    @if('conditions' !== Route::currentRouteName()) <a href="{{ route('conditions') }}">СОГЛАШЕНИЕ ОБ
                        ИСПОЛЬЗОВАНИИ</a> @endif
                    @if('partnership' !== Route::currentRouteName()) <a
                            href="{{ route('partnership') }}">ПАРТНЕРСТВО</a> @endif
                    @if('video-otzyvy' !== Route::currentRouteName()) <a href="#">ВИДЕО ОТЗЫВЫ</a> @endif
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