@if ($menu)
    <nav>
        <div class="burger">
            <div class="line-burger"></div>
            <div class="line-burger"></div>
            <div class="line-burger"></div>
        </div>
        <div class="menu-left">
            <div class="person patient menu-elem active">Я пациент</div>
            <div id="toggles" class="toggles">
                <input type="checkbox" name="checkbox1" id="checkbox1" class="ios-toggle" checked/>
                <label for="checkbox1" class="checkbox-label"></label>
            </div>
            <div class="person doctor menu-elem">Я врач</div>
        </div>

        <div class="header-menu-left">
            <div class="nav_container active">
                <ul id="main-menu" class="menu">
                    <li class="with-sub menu-elem"><img src="{{ asset('estet') }}/img/menu/1.png"><a href="#">Статьи</a>
                        <ul class="submenu">
                            <li class="col">
                                {!! Menu::get('menu')->asUl() !!}
                            </li>
                        </ul>
                    </li>
                    @if(session()->has('doc'))
                        <li class="menu-elem"><a href="{{ route('events') }}"><span>Мероприятия</span></a></li>
                        <li class="menu-elem"><a href="{{ route('blogs') }}"><span>Блог</span></a></li>
                        <li class="menu-elem"><a href="{{ route('docs_cat', 'video') }}">
                                <img src="{{ asset('estet') }}/img/menu/3.png"><span>Видео</span></a></li>
                    @else
                        <li class="menu-elem"><a href="{{ route('horoscope') }}"><span>Гороскоп</span></a></li>
                        <li class="menu-elem"><a href="{{ route('article_cat', 'video') }}"><img
                                        src="{{ asset('estet') }}/img/menu/3.png"><span>Видео</span></a></li>
                        <li class="menu-elem"><a href="{{ route('article_cat', 'intervyu') }}"><img
                                        src="{{ asset('estet') }}/img/menu/2.png"><span>Интервью</span></a></li>
                    @endif
                    <li class="with-sub menu-elem"><a href=""><img src="{{ asset('estet') }}/img/menu/4.png"><span>Каталог</span></a>
                        <ul class="submenu">
                            <li class="col">
                                <ul>
                                    <li><a href="{{ route('docs') }}">Врачи</a></li>
                                    <li><a href="{{ route('clinics') }}">Клиники</a></li>
                                    <li><a href="{{ route('distributors') }}">Дистрибьюторы</a></li>
                                    <li><a href="{{ route('brands') }}">Бренды</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="with-sub menu-elem last-elem">
                        <img src="{{ asset('estet') }}/img/menu/5.png">
                        <a href="">Еще</a>
                        <ul class="submenu">
                            <li class="col">
                                <ul>
                                    <li><a href="{{ route('about') }}">О проекте</a></li>
                                    <li><a href="{{ route('advertising') }}">Реклама</a></li>
                                    <li><a href="{{ route('contacts') }}">Обратная связь</a></li>
                                    <li><a href="{{ route('sitemap') }}">Карта сайта</a></li>
                                    <li><a href="{{ route('conditions') }}">Соглашение об использовании</a></li>
                                    <li><a href="{{ route('partnership') }}">Партнерство</a></li>
                                    <li><a href="#">Видео отзывы</a></li>
                                </ul>

                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="memu-search menu-elem">
                <div class="search-mobb ">
                    <form>
                        <input class="search-mob" type="search" name="q" placeholder="Искать...">
                    </form>
                </div>
                <div class="search" id="search"><img src="{{ asset('estet') }}/img/menu/search.png"></div>
            </div>
        </div>
    </nav>
@endif