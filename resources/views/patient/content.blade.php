@if(!empty($articles))
    <!--section 1-->
    <section id="section-1" class="last-articles">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Последние статьи</h2>
            </div>
        </div>
        <div class="content">
            <!--slider & ad-->
            <div class="slider-wrap">
                <div class="slider">
                    <article>
                        <div class="slide-left"><a class="link-img"
                                                   href="{{ route('articles',$articles['lasts'][0]->alias) }}"
                                                   rel="nofollow">
                                <img src="{{ asset('/images/article/middle').'/'.$articles['lasts'][0]->path }}"
                                     alt="{{ $articles['lasts'][0]->alt }}"
                                     title="{{ $articles['lasts'][0]->img_title }}"></a>
                        </div>
                        <div class="slide-right">
                            <div class="slide-right_top">
                                <div class="title-time">
                                    <a href="{{ route('article_cat', $articles['lasts'][0]->cat_alias) }}">{{ $articles['lasts'][0]->name }}</a>
                                    <time><i class="icons icon-clock"></i>{{ $articles['lasts'][0]->created }}</time>
                                </div>
                                <a href="{{ route('articles',$articles['lasts'][0]->alias) }}" rel="nofollow">
                                    <h3>{{ $articles['lasts'][0]->title }}</h3></a>
                                {!! str_limit($articles['lasts'][0]->content, 1200) !!}
                            </div>
                            <div class="slide-right_bot"><a class="btn-blue"
                                                            href="{{ route('articles',$articles['lasts'][0]->alias) }}">Подробнее</a>
                            </div>
                        </div>
                    </article>
                </div>
                <aside class="ad">
                    {!! $advertising['main_1'] ?? '<img src="'. asset('estet') .'/img/content/Group 4058.png" >' !!}
                </aside>
            </div>
            <!--articles-gray-->
            <div class="articles-horizontal">
                @foreach($articles['lasts'] as $article)
                    @if($loop->iteration < 4)
                        @continue
                    @endif
                    <article>
                        <a class="link-img" href="{{ route('articles', $article->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$article->path }}" alt="{{ $article->alt }}"
                                 title="{{ $article->img_title }}">
                        </a>
                        <div class="title-time">
                            <a href="{{ route('article_cat', $article->cat_alias) }}">{{ $article->name }}</a>
                            <time><i class="icons icon-clock"></i>{{ $article->created }}</time>
                        </div>
                        <a class="link-title" href="{{ route('articles', $article->alias) }}">
                            <h3>{{ $article->title }}</h3>
                        </a>
                    </article>
                    @if(!$loop->last)
                        <div class="line-vertical"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!--section 2-->
    <section id="section-2" class="most-popular">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Самое популярное</h2>
            </div>
        </div>
        <div class="content articles-divisions">
            <div class="article-big">
                <article>
                    <a class="link-img" href="{{ route('articles', $articles['popular'][0]->alias) }}" rel="nofollow">
                        <img src="{{ asset('/images/article/main').'/'.$articles['popular'][0]->path }}"
                             alt="{{ $articles['popular'][0]->alt }}" title="{{ $articles['popular'][0]->img_title }}">
                    </a>
                    <div class="title-time">
                        <time>{{ $articles['popular'][0]->created }}</time>
                    </div>
                    <a class="link-title" href="{{ route('articles', $articles['popular'][0]->alias) }}">
                        <h3>{{ $articles['popular'][0]->title }}</h3>
                    </a>
                </article>
            </div>

            <div class="articles-vertical">
                @foreach($articles['popular'] as $article)
                    @if($loop->first)
                        @continue
                    @endif
                    <article>
                        <a class="link-img" href="{{ route('articles', $article->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$article->path }}" alt="{{ $article->alt }}"
                                 title="{{ $article->img_title }}">
                        </a>
                        <div>
                            <div class="title-time">
                                <time>{{ $article->created }}</time>
                            </div>
                            <a class="link-title" href="{{ route('articles', $article->alias) }}">
                                <h3>{{ $article->title }}</h3>
                            </a>
                        </div>
                    </article>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!--section 3-->
    <section id="section-3" class="video">

        <div class="left-title">
            <div class="line-container">

                <div class="vertical-line"></div>
                <h2>Видео</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-horizontal">
                @foreach($articles['video'] as $video)
                    <article>
                        <a class="link-img" href="{{ route('articles', $video->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$video->path }}" alt="{{ $video->alt }}"
                                 title="{{ $video->img_title }}">
                        </a>
                        <div class="title-time">
                            <time>{{ $video->created }}</time>
                            <div class="horizontal-line"></div>
                        </div>
                        <a class="link-title" href="">
                            <h3>{{ $video->title }}</h3>
                        </a>
                    </article>
                    @if(!$loop->last)
                        <div class="line-vertical"></div>
                @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['video'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 4-->
    <!--<section id="section-4" class="interesting-facts">-->
    <!--<div class="left-title">-->
    <!--<div class="line-container">-->
    <!--<div class="vertical-line"></div>-->
    <!--<h2>Диета  и питание</h2>-->
    <!--</div>-->
    <!--</div>-->
    <!--<div class="content"></div>-->
    <!--</section>-->

    <!--section 5-->
    <section id="section-5" class="diet-food">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Диета и питание</h2>
            </div>
        </div>
        <div class="content articles-divisions">
            <div class="article-big">
                <article>
                    <a class="link-img" href="{{ route('articles', $articles['diet'][0]->alias) }}" rel="nofollow">
                        <img src="{{ asset('/images/article/main').'/'.$articles['diet'][0]->path }}"
                             alt="{{ $articles['diet'][0]->alt }}" title="{{ $articles['diet'][0]->img_title }}">
                    </a>
                    <div class="title-time">
                        <time>{{ $articles['diet'][0]->created }}</time>
                    </div>
                    <a class="link-title" href="{{ route('articles', $articles['diet'][0]->alias) }}">
                        <h3>{{ $articles['diet'][0]->title }}</h3>
                    </a>
                </article>
            </div>
            <div class="articles-vertical">
                @foreach($articles['diet'] as $article)
                    @if($loop->first)
                        @continue
                    @endif
                    <article>
                        <a class="link-img" href="{{ route('articles', $article->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$article->path }}" alt="{{ $article->alt }}"
                                 title="{{ $article->img_title }}">
                        </a>
                        <div>
                            <div class="title-time">
                                <time>{{ $article->created }}</time>
                            </div>
                            <a class="link-title" href="{{ route('articles', $article->alias) }}">
                                <h3>{{ $article->title }}</h3>
                            </a>
                        </div>
                    </article>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['diet'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 6-->
    <section id="section-6" class="beauty-health">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Красота и здоровье</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-horizontal">
                @foreach($articles['beauty'] as $beauty)
                    <article>
                        <a class="link-img" href="{{ route('articles', $beauty->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$beauty->path }}" alt="{{ $beauty->alt }}"
                                 title="{{ $beauty->img_title }}">
                        </a>
                        <div class="title-time">
                            <time>{{ $beauty->created }}</time>
                            <div class="horizontal-line"></div>
                        </div>
                        <a class="link-title" href="">
                            <h3>{{ $beauty->title }}</h3>
                        </a>
                    </article>
                    @if(!$loop->last)
                        <div class="line-vertical"></div>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['beauty'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 7-->
    <section id="section-7" class="medicine-treatment">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Медицина и лечение</h2>
            </div>
        </div>
        <div class="content articles-divisions">
            <div class="article-big">
                <article>
                    <a class="link-img" href="{{ route('articles', $articles['medicine'][0]->alias) }}" rel="nofollow">
                        <img src="{{ asset('/images/article/main').'/'.$articles['medicine'][0]->path }}"
                             alt="{{ $articles['medicine'][0]->alt }}"
                             title="{{ $articles['medicine'][0]->img_title }}">
                    </a>
                    <div class="title-time">
                        <time>{{ $articles['medicine'][0]->created }}</time>
                    </div>
                    <a class="link-title" href="{{ route('articles', $articles['medicine'][0]->alias) }}">
                        <h3>{{ $articles['medicine'][0]->title }}</h3>
                    </a>
                </article>
            </div>
            <div class="articles-vertical">
                @foreach($articles['medicine'] as $article)
                    @if($loop->first)
                        @continue
                    @endif
                    <article>
                        <a class="link-img" href="{{ route('articles', $article->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$article->path }}" alt="{{ $article->alt }}"
                                 title="{{ $article->img_title }}">
                        </a>
                        <div>
                            <div class="title-time">
                                <time>{{ $article->created }}</time>
                            </div>
                            <a class="link-title" href="{{ route('articles', $article->alias) }}">
                                <h3>{{ $article->title }}</h3>
                            </a>
                        </div>
                    </article>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['medicine'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 8-->
    <section id="section-8" class="helpful-tips">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Полезные советы</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-horizontal">
                @foreach($articles['psychology'] as $psychology)
                    <article>
                        <a class="link-img" href="{{ route('articles', $psychology->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$psychology->path }}"
                                 alt="{{ $psychology->alt }}" title="{{ $psychology->img_title }}">
                        </a>
                        <div class="title-time">
                            <time>{{ $psychology->created }}</time>
                            <div class="horizontal-line"></div>
                        </div>
                        <a class="link-title" href="">
                            <h3>{{ $psychology->title }}</h3>
                        </a>
                    </article>
                    @if(!$loop->last)
                        <div class="line-vertical"></div>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['psychology'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 9-->
    <section id="section-9" class="horoscope-patient">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Гороскоп красоты</h2>
            </div>
        </div>
        <div class="content">
            <div class="hrp ">
                <a href="#oven" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-oven-active"></i>
                            <i class="horoscope-icons horoscope-icons-oven"></i>
                        </div>
                        <span>ОВЕН</span>
                    </div>
                </a>
                <a href="#telets" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-telets-active"></i>
                            <i class="horoscope-icons horoscope-icons-telets"></i>
                        </div>
                        <span>ТЕЛЕЦ</span>
                    </div>
                </a>
                <a href="#bliznetsy" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-bliznetsy-active"></i>
                            <i class="horoscope-icons horoscope-icons-bliznetsy"></i>
                        </div>
                        <span>БЛИЗНЕЦЫ</span>
                    </div>
                </a>
                <a href="#rak" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-rak-active"></i>
                            <i class="horoscope-icons horoscope-icons-rak"></i>
                        </div>
                        <span>РАК</span>
                    </div>
                </a>
                <a href="#lev" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-lev-active"></i>
                            <i class="horoscope-icons horoscope-icons-lev"></i>
                        </div>
                        <span>ЛЕВ</span>
                    </div>
                </a>

                <a href="#deva" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-deva-active"></i>
                            <i class="horoscope-icons horoscope-icons-deva"></i>
                        </div>
                        <span>ДЕВА</span>
                    </div>
                </a>
                <a href="#vesy" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-vesy-active"></i>
                            <i class="horoscope-icons horoscope-icons-vesy"></i>
                        </div>
                        <span>ВЕСЫ</span>
                    </div>
                </a>
                <a href="#skorpion" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-skorpion-active"></i>
                            <i class="horoscope-icons horoscope-icons-skorpion"></i>
                        </div>
                        <span>СКОРПИОН</span>
                    </div>
                </a>
                <a href="#strelets" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-strelets-active"></i>
                            <i class="horoscope-icons horoscope-icons-strelets"></i>
                        </div>
                        <span>СТРЕЛЕЦ</span>
                    </div>
                </a>

                <a href="#kozerog" class="icons-img z-index-item-up">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-kozerog-active"></i>
                            <i class="horoscope-icons horoscope-icons-kozerog"></i>
                        </div>
                        <span>КОЗЕРОГ</span>
                    </div>
                </a>
                <a href="#vodoley" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-vodoley-active"></i>
                            <i class="horoscope-icons horoscope-icons-vodoley"></i>
                        </div>
                        <span>ВОДОЛЕЙ</span>
                    </div>
                </a>
                <a href="#riba" class="icons-img z-index-item-down">
                    <div class="horo">
                        <div class="icon-wrap">
                            <i class="horoscope-icons horoscope-icons-riba-active"></i>
                            <i class="horoscope-icons horoscope-icons-riba"></i>
                        </div>
                        <span>РЫБЫ</span>
                    </div>
                </a>
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('horoscope') }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 10-->
    <section id="section-10" class="stomatology">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Стоматология</h2>
            </div>
        </div>
        <div class="content articles-divisions">
            <div class="article-big">
                <article>
                    <a class="link-img" href="{{ route('articles', $articles['stomatology'][0]->alias) }}"
                       rel="nofollow">
                        <img src="{{ asset('/images/article/main').'/'.$articles['stomatology'][0]->path }}"
                             alt="{{ $articles['stomatology'][0]->alt }}"
                             title="{{ $articles['stomatology'][0]->img_title }}">
                    </a>
                    <div class="title-time">
                        <time>{{ $articles['stomatology'][0]->created }}</time>
                    </div>
                    <a class="link-title" href="{{ route('articles', $articles['stomatology'][0]->alias) }}">
                        <h3>{{ $articles['stomatology'][0]->title }}</h3>
                    </a>
                </article>
            </div>
            <div class="articles-vertical">
                @foreach($articles['stomatology'] as $article)
                    @if($loop->first)
                        @continue
                    @endif
                    <article>
                        <a class="link-img" href="{{ route('articles', $article->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$article->path }}" alt="{{ $article->alt }}"
                                 title="{{ $article->img_title }}">
                        </a>
                        <div>
                            <div class="title-time">
                                <time>{{ $article->created }}</time>
                            </div>
                            <a class="link-title" href="{{ route('articles', $article->alias) }}">
                                <h3>{{ $article->title }}</h3>
                            </a>
                        </div>
                    </article>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['stomatology'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>

    <!--section 11-->
    <section id="section-11" class="psychology">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line"></div>
                <h2>Психология</h2>
            </div>
        </div>
        <div class="content ">
            <div class="articles-horizontal">
                @foreach($articles['psychology'] as $psychology)
                    <article>
                        <a class="link-img" href="{{ route('articles', $psychology->alias) }}" rel="nofollow">
                            <img src="{{ asset('/images/article/small').'/'.$psychology->path }}"
                                 alt="{{ $psychology->alt }}" title="{{ $psychology->img_title }}">
                        </a>
                        <div class="title-time">
                            <time>{{ $psychology->created }}</time>
                            <div class="horizontal-line"></div>
                        </div>
                        <a class="link-title" href="">
                            <h3>{{ $psychology->title }}</h3>
                        </a>
                    </article>
                    @if(!$loop->last)
                        <div class="line-vertical"></div>
                    @endif
                @endforeach
            </div>
            <div class="button-block">
                <div class="button-line"></div>
                <a href="{{ route('article_cat', $articles['psychology'][0]->cat_alias) }}">Перейти к разделу</a>
            </div>
        </div>
    </section>
@endif