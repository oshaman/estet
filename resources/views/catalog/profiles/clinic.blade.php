<section id="section-1" class="blog-page">
    <div class="left-title">
        <div class="line-container text-vertical">
            <div class="vertical-line
            @if(session()->has('doc')) line-purple @endif
                    ">
            </div>
            <h2>Каталог</h2>
        </div>
    </div>
    <div class="content">
        <!-- section 2 -->
        <div class="bread-crumbs">
            <div itemscope itemtype="#">
                <a href="#" itemprop="url">
                    <span itemprop="title">Клиники</span>
                </a>
            </div>/
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
                                    <img src="{{ asset('/images/establishment/main') . '/' . $clinic->logo }}"
                                         alt="{{ $clinic->alt }}" title="{{ $clinic->title }}">
                                    <div class="details-page-info">
                                        <div class="rating">
                                            <div class="top-rating" data-id="{{ $clinic->id }}" data-source="1">
                                                <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                                            </div>
                                            <p>{{ ($ratio->avg ?? 0) .' / 5 - (' . $ratio->count . ' голосов)'}}</p>

                                        </div>
                                        <div class="info-kompani">
                                            <div class="kompani-contacts">
                                                <p>Категория:</p>
                                                <span>{{ trans('ru.' . $clinic->category) }}</span>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Специализация:</p>
                                                {{ $clinic->spec }}
                                            </div>
                                            @isset($clinic->extra[0])
                                                <div class="kompani-contacts">
                                                    <p>{{ $clinic->extra[0][0] }}</p>
                                                    {{ $clinic->extra[0][1] }}
                                                </div>
                                            @endisset
                                            @isset($clinic->extra[1])
                                                <div class="kompani-contacts">
                                                    <p>{{ $clinic->extra[1][0] }}</p>
                                                    {{ $clinic->extra[1][1] }}
                                                </div>
                                            @endisset
                                            <div class="kompani-contacts">
                                                <div class="contacts-tel">
                                                    <p>Телефон:</p>
                                                </div>
                                                <div class="contacts-tel">
                                                    <a href="tel: +3800443312425">{{ $clinic->phones }}</a>
                                                </div>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Web-сайт:</p>
                                                <a href="{{ $clinic->site }}">{{ $clinic->site }}</a>
                                            </div>
                                        </div>
                                        <div class="kervices-kompani">
                                            @if(!empty($clinic->services))
                                                <p>Услуги:</p>
                                                <lu>
                                                    @foreach($clinic->services as $service)
                                                        <li>{{ $service }}</li>
                                                    @endforeach
                                                </lu>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="details-page">
                                    <h3>{{ $clinic->title }}</h3>
                                    <p>Комплексная разработка и сопровождение предприятий индустрии красоты и
                                        здоровья, включая как SPA & Wellness объекты, так и медицинские у
                                        чреждения
                                    </p>
                                    <hr>
                                    <span>{{ $clinic->address }}</span>
                                    <div class="kompani-info">
                                        <div class="brand-head">
                                            <div class="katalog-line"></div>
                                            <span>О нас</span>
                                        </div>
                                        {!! $clinic->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section-5 -->
                        <div class="brand-publications">
                            <div class="brand-head">
                                <div class="katalog-line"></div>
                                <span>Публикации клиники</span>
                            </div>
                            @if(!empty($clinic->articles))
                                <div class="publications">
                                    @foreach($clinic->articles as $article)
                                        <article>
                                            <a href="{{ route('articles', $article->alias) }}"><p>{{ $article->title }}</p></a>
                                        </article>
                                        @if(!$loop->last) <hr> @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @include('layouts.comments_form', ['id' => $clinic->id, 'source' => 3])
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
        {!! $sidebar !!}

    </div>
</section>



{{--<h2>{{ trans('ru.clinics') }}---------------------------------------------------</h2>
<div class="row">
    <div class="col-lg-4">
        <div class="row">{{ Html::image(asset('/images/establishment/main') . '/' . $clinic->logo, $clinic->title, array('class' => 'img-thumbnail')) }}</div>
        <div class="row">***** оценка {{ ($ratio->avg ?? 0) .' / 5 - (' . $ratio->count . ' проголосовавших)'}}</div>
        <div class="d-block bg-info">
            <div><strong>Категория: </strong>{{ trans('ru.' . $clinic->category) }}</div>
            <div><strong>Телефоны: </strong>{{ $clinic->phones }}</div>
            <div><strong>Сайт: </strong>{{ $clinic->site }}</div>
            <div><strong>Спецификация: </strong>{{ $clinic->spec }}</div>
            @if(!empty($clinic->services))
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#service">Услуги: </a>
                    </h4>
                </div>
                <div id="service" class="panel-collapse collapse">
                    @foreach($clinic->services as $service)
                        <div class="panel-body">{{ $service }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row"><h2 class="text-center">{{ $clinic->title }}</h2></div>
        <hr>
        <div class="row">{{ $clinic->address }}</div>
        <h3>О нас</h3>
        <div class="row">{!! $clinic->content !!}</div>
    </div>
</div>
<hr>
@if(!empty($clinic->articles))
    <div class="row bg-warning">
        <h4>Публикации клиники ========================================</h4>
        @foreach($clinic->articles as $article)
            <a href="{{ route('articles', $article->alias) }}">{{ $article->title }}</a>
            <hr>
        @endforeach
    </div>
@endif
@if(count($clinic->comments) > 0)
    <hr>
    @foreach($clinic->comments as $comment)
        @if(0 !== $comment->parent_id)
            @continue
        @endif
        <div class="row">
            <table class="table">
                <tr><th>#</th><th>{{ $comment->id }}</th></tr>
                <tr><td>E-mail</td><td>{{ $comment->email }}</td></tr>
                <tr><td>Имя</td><td>{{ $comment->name }}</td></tr>
                <tr><td>Коментарий</td><td>{{ $comment->text }}</td></tr>
            </table>
        </div>
        @include('comment', ['children' => $clinic->comments, 'id' => $comment->id])
    @endforeach
@endif
<hr>
<div class="row">
    <h4>Добавить коментарий</h4>
    <div class="row">
        {!! Form::open(['url' => route('comments'),'class'=>'form-horizontal','method'=>'post']) !!}
        {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Ваша почта', 'id'=>'email', 'class'=>'form-control']) !!}
        {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Имя', 'id'=>'name', 'class'=>'form-control']) !!}
        {!! Form::textarea('text', old('text') ? : '' , ['placeholder'=>'Коментарий', 'id'=>'text', 'class'=>'form-control', 'rows'=>5, 'cols'=>50]) !!}
        {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {{ Form::hidden('comment_post_ID', $clinic->id) }}
        {{ Form::hidden('comment_parent', 0) }}
        {{ Form::hidden('comment_source', 3) }}
        {!! Form::close() !!}
    </div>
</div>
<hr>--}}
