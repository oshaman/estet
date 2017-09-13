<section id="section-1" class="blog-page">
    <div class="left-title">
        <div class="line-container text-vertical">
            <div class="vertical-line
             @if(session()->has('doc')) line-purple @endif
                    "></div>
            <h2>Каталог</h2>
        </div>
    </div>
    <div class="content">
        <!-- section 2 -->
        <div class="bread-crumbs">
            <div itemscope itemtype="#">
                <a href="#" itemprop="url">
                    <span itemprop="title">Врачи</span>
                </a>
            </div>
            /
            <div itemscope itemtype="#">
                <span itemprop="title">Alfa Spa Development</span>
            </div>
        </div>
        <div class="katalog-page">

            <div class="main-content page-content">
                <!-- section-3 -->
            @include('catalog.nav')

            <!-- section-4 -->
                <div class="blog-section-post">
                    <div class="content content-blog">
                        <div class="catalog-internal">
                            <div class="block-info">
                                <div class="details-page">
                                    <img src="{{ asset(config('settings.theme'))  . '/img/profile/main/' . ($profile->photo ?? '../no_photo.jpg') }}"
                                         alt="{{ $profile->lastname }}" title="{{ $profile->lastname }}">
                                    <div class="details-page-info">
                                        <div class="rating">
                                            <div class="top-rating" data-id="{{ $profile->id }}" data-source="2">
                                                <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                                            </div>
                                            {{--<p>{{ ($ratio->avg ?? 0) .' / 5 - (' . $ratio->count . ' голосов)'}}</p>--}}

                                        </div>
                                        <div class="info-kompani">
                                            <div class="kompani-contacts">
                                                <p>Специализация:</p>
                                                <span>{{ $profile->specialties->implode('name', ', ') ?? ''}}</span>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Регалии:</p>
                                                <span>{{ $profile->category ?? ''}}</span>
                                            </div>
                                            <div class="kompani-contacts">
                                                <div class="contacts-tel">
                                                    <p>Телефон:</p>
                                                </div>
                                                <div class="contacts-tel">
                                                    <a href="tel: +3800443312425">{{ $profile->phone ?? ''}}</a>
                                                </div>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Web-сайт:</p>
                                                <a href="{{ $profile->site ?? ''}}">{{ $profile->site ?? ''}}</a>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Опыт работы(полных лет):</p>
                                                {{ $profile->expirience ?? ''}}
                                            </div>
                                            @isset($brand->extra[0])
                                                <div class="kompani-contacts">
                                                    <p>{{ $brand->extra[0][0] }}</p>
                                                    {{ $brand->extra[0][1] }}
                                                </div>
                                            @endisset
                                            @isset($brand->extra[1])
                                                <div class="kompani-contacts">
                                                    <p>{{ $brand->extra[1][0] }}</p>
                                                    {{ $brand->extra[1][1] }}
                                                </div>
                                            @endisset
                                        </div>
                                        <div class="kervices-kompani">
                                            @if(!empty($profile->services) && is_array($profile->services))
                                                <p>Услуги:</p>
                                                <lu>
                                                    @foreach($profile->services as $service)
                                                        <li>{{ $service }}</li>
                                                    @endforeach
                                                </lu>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="details-page">
                                    <h3>{{ $profile->name .' '. $profile->lastname}}</h3>
                                    <p>
                                        {{ $profile->job ?? ''}}
                                    </p>
                                    <hr>
                                    <span>{{ $profile->address ?? ''}}</span>
                                    <div class="kompani-info">
                                        <div class="brand-head">
                                            <div class="katalog-line"></div>
                                            <span>О докторе</span>
                                        </div>
                                        {!! $profile->content ?? '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section-5 -->
                        <div class="brand-publications">
                            <div class="brand-head">
                                <div class="katalog-line"></div>
                                <span>Публикации доктора</span>
                            </div>
                            @if(!empty($blogs))
                                <div class="publications">
                                    @foreach($blogs as $blog)
                                        <article>
                                            <a href="{{ route('blogs', $blog->alias) }}"><p>{{ $blog->title }}</p></a>
                                        </article>
                                        @if(!$loop->last)
                                            <hr> @endif
                                    @endforeach

                                </div>
                            @endif
                        </div>
                        <div class="comment-post">
                            @include('layouts.social-networks')
                            {{--@include('layouts.comments_form', ['id' => $profile->id, 'source' => 3])--}}
                            <div class="about-description">
                                <h4>О рубрике Каталог</h4>
                                <p>Раздел «Мероприятия» позволяет всем заинтересованным в сфере эстетической
                                    медицины не пропустить медицинские мероприятия, которые помогут не только
                                    постоянно следить за мировыми и местными событиями, интересными для
                                    врачей-эстетистов и специалистов других отраслей медицины, но и позволят
                                    расширить базу знаний и завести новые знакомства, получить бесценный опыт
                                    и повысить свою квалификацию. Медицинские мероприятия для профессионалов
                                    включают в себя тренинги, практикумы, обучающие курсы, конференции,
                                    выставки и прочие события в мире медицины..</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! $sidebar !!}
    </div>
</section>


{{--
@if (!empty($profile))
<div class="row">
    <div class="col-xs-6">
        <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
    </div>
    <div class="col-xs-6">
        <div class="row">
            <h3>{{ $profile->name ?? ''}}</h3>
            <h3>{{ $profile->lastname ?? ''}}</h3>
            <hr>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-lg-3"><h5>Специализация: </h5></div>
                    <div class="col-lg-9"><h5>{{ $profile->specialties->implode('name', ', ') ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Опыт: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->expirience ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Адрес: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->address ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Телефон: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->phone ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>E-mail: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->email ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Сайт: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->site ?? ''}}</h5></div>
            </div>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8">
        <h3>О враче</h3>
        {{ $profile->content ?? ''}}
    </div>
    <div class="col-xs-4">
        <div class="row">
            <h3>Место работы:</h3>
            {{ $profile->job ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Расписание:</h3>
            {{ $profile->shedule ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Категория:</h3>
            {{ $profile->category ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Услуги:</h3>
            @if(!empty($profile->services) && is_array($profile->services))
                <ul>
                    @foreach($profile->services as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                </ul>
            @endif
            <hr>
        </div>
    </div>
</div>
    @if($blogs)
    <div class="row">
        @foreach($blogs as $blog)
            <div class="row">
                <div class="col-md-6">
                    {{ Html::image(asset('/images/blog/small') . '/' . $blog->blog_img->path, $blog->blog_img->alt, ['title' => $blog->blog_img->title]) }}
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <span>{{ $blog->category->name }}</span> <span class="label label-default">{{ $blog->created }}</span>
                    </div>
                    <h2>{{ $blog->title }}</h2>
                    <h5>{{ $profile->name . ' ' . $profile->lastname }}</h5>
                    <p>
                        {!! Form::open(['url' => route('blogs',['blog'=> $blog->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    @endif
@endif--}}
