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
                    <span itemprop="title">Дистрибуторы</span>
                </a>
            </div>/
            <div itemscope itemtype="#">
                <span itemprop="title">Alfa Spa Development</span>
            </div>
        </div>
        <div class="katalog-page">

            <div class="main-content page-content">
                <!-- section-3 -->
                {!! $nav !!}

                        <!-- section-4 -->
                <div class="blog-section-post">
                    <div class="content content-blog">
                        <div class="catalog-internal">
                            <div class="block-info">
                                <div class="details-page">
                                    <img src="{{ asset('/images/establishment/main') . '/' . $distributor->logo }}"
                                         alt="{{ $distributor->alt }}" title="{{ $distributor->title }}">
                                    <div class="details-page-info">
                                        <div class="rating">
                                            <div class="top-rating">
                                                <span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>
                                            </div>
                                            <p>{{ ($ratio->avg ?? 0) .' / 5 - (' . $ratio->count . ' голосов)'}}</p>

                                        </div>
                                        <div class="info-kompani">
                                            <div class="kompani-contacts">
                                                <p>Категория:</p>
                                                <span>{{ trans('ru.' . $distributor->category) }}</span>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Дочерние бренды:</p>
                                                @if(!empty($children))
                                                    <div id="children" class="panel-collapse collapse">
                                                        @foreach($children as $child)
                                                            <a href="{{ route('brands', $child->alias) }}"><span>{{ $child->title }}</span></a>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="kompani-contacts">
                                                <div class="contacts-tel">
                                                    <p>Телефон:</p>
                                                    <p>Факс:</p>
                                                </div>
                                                <div class="contacts-tel">
                                                    <a href="tel: +3800443312425">{{ $distributor->phones }}</a>
                                                </div>
                                            </div>
                                            <div class="kompani-contacts">
                                                <p>Web-сайт:</p>
                                                <a href="{{ $distributor->site }}">{{ $distributor->site }}</a>
                                            </div>
                                        </div>
                                        <div class="working-hours">
                                            <p>Время работы:</p>
                                            <span>c<time>10:00</time>до<time>21:00</time></span>
                                        </div>
                                        <div class="kervices-kompani">
                                            @if(!empty($distributor->services))
                                                <p>Категории товаров:</p>
                                                <lu>
                                                    @foreach($distributor->services as $service)
                                                        <li>{{ $service }}</li>
                                                    @endforeach
                                                </lu>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="details-page">
                                    <h3>{{ $distributor->title }}</h3>
                                    <p>Комплексная разработка и сопровождение предприятий индустрии красоты и
                                        здоровья, включая как SPA & Wellness объекты, так и медицинские у
                                        чреждения
                                    </p>
                                    <hr>
                                    <span>{{ $distributor->address }}</span>
                                    <div class="kompani-info">
                                        <div class="brand-head">
                                            <div class="katalog-line"></div>
                                            <span>О нас</span>
                                        </div>
                                        {!! $distributor->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section-5 -->
                        <div class="brand-publications">
                            <div class="brand-head">
                                <div class="katalog-line"></div>
                                <span>Публикации дистрибутора</span>
                            </div>
                            @if(!empty($distributor->articles))
                                <div class="publications">
                                    @foreach($distributor->articles as $article)
                                        <article>
                                            <a href="{{ route('articles', $article->alias) }}"><p>{{ $article->title }}</p></a>
                                        </article>
                                        @if(!$loop->last) <hr> @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="comment-post">
                            @include('layouts.social-networks')
                            @include('layouts.comments_form', ['id' => $distributor->id, 'source' => 3])
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
@if(count($distributor->comments) > 0)
    <hr>
    @foreach($distributor->comments as $comment)
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
        @include('comment', ['children' => $distributor->comments, 'id' => $comment->id])
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
        {{ Form::hidden('comment_post_ID', $distributor->id) }}
        {{ Form::hidden('comment_parent', 0) }}
        {{ Form::hidden('comment_source', 3) }}
        {!! Form::close() !!}
    </div>
</div>
<hr>--}}
