<section id="section-1" class="meropryyatyya">
    <div class="left-title">
        <div class="line-container text-vertical">
            <div class="vertical-line line-purple"></div>
            <h2>Мероприятия</h2>
        </div>
    </div>
    <div class="content">
        <div class="main-content">
            <!--section 2-->
            <h3>{{ $event->title }}</h3>
            <!--section 3-->
            <div class="img-meropryyatyya">
                <img src="{{ asset('/images/event/main') . '/' . $event->logo->path }}"
                     alt="{{ $event->logo->alt }}" title="$event->logo->title">
            </div>
            <!--section 4-->
            <div class="button-subscribe">
                <a href="#"><i class="icon-subscribe"></i> Записаться на мероприятие</a>
            </div>
            <!--section 5-->
            <div class="text-meropryyatyya">
                {{ $event->description }}
            </div>
            <!--section 6-->
            <div class="slide-meropryyatyya">
                @foreach($event->slider as $slider)
                    <img src="{{ asset('/images/event/slider/main') . '/' . $slider->path }}"
                         alt="{{ $slider->alt }}" title="{{ $slider->title }}">
                @endforeach
            </div>
            <div class="meropryyatyya-data">
                {!! $event->content !!}
            </div>


            <div class="button-subscribe">
                <a href="#"><i class="icon-subscribe"></i> Записаться на мероприятие</a>
            </div>
            <!--section 7-3-->
            @include('layouts.comments_form', ['id' => $event->id, 'source' => 4])
        </div>
        <!--section 8-->
        {!! $sidebar !!}
    </div>
</section>



<!--section 9-->
    <section id="section-2" class="meropryyatyya-health">
        <div class="left-title">
            <div class="line-container">
                <div class="vertical-line line-purple"></div>
                <h2>Похожие</h2>
            </div>
        </div>
        <div class="content">
            <div class="articles-horizontal">
                @if(!empty($similars))
                    @foreach($similars as $event)
                        <article>
                            <a class="link-img" href="{{ route('events', $event->alias) }}" rel="nofollow">
                                <img src="{{ asset('images\event\mini').'/'. $event->logo->path}}"
                                     alt="{{ $event->logo->alt }}"
                                     title="{{ $event->logo->title }}"
                                >
                            </a>
                            <div class="title-time">
                                <time>
                                    @if(strlen($event->created) < 6) <i class="icons icon-clock"></i> @endif
                                    {{ $event->created }}
                                </time>
                            </div>
                            <a class="link-title" href="{{ route('events', $event->alias) }}">
                                <h3>{{ $event->title }}</h3>
                            </a>
                        </article>
                        @if(!$loop->last)
                            <div class="line-vertical"></div>
                        @endif
                    @endforeach
                @endif
            </div>

        </div>
    </section>

</div>
<!--section 10-->

<section id="section-3" class="about-heading">
    <div class="content-about">
        <div class="about-description">
            <h4>О рубрике Мероприятия</h4>
            <p>Раздел «Мероприятия» позволяет всем заинтересованным в сфере эстетической медицины не пропустить медицинские
                мероприятия, которые помогут не только постоянно следить за мировыми и местными событиями, интересными для
                врачей-эстетистов и специалистов других отраслей медицины, но и позволят расширить базу знаний и завести
                новые знакомства, получить бесценный опыт и повысить свою квалификацию. Медицинские мероприятия для
                профессионалов включают в себя тренинги, практикумы, обучающие курсы, конференции, выставки и прочие
                события в мире медицины.</p>
        </div>
    </div>
</section>
{{--
<h1>{{ $event->title }}</h1>
<div class="thumbnail">
    {{ Html::image(asset('/images/event/main') . '/' . $event->logo->path, $event->logo->alt, ['title' => $event->logo->title]) }}
</div>
<div class="row">{{ $event->description }}</div>
<hr>
--}}
{{--Slider--}}{{--

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach($event->slider as $slider)
            @if ($loop->first)
                <div class="item active">
                    @else
                        <div class="item">
                            @endif
                            <img src="{{ asset('/images/event/slider/main') . '/' . $slider->path }}"
                                 alt="{{ $slider->alt }}" title="{{ $slider->title }}">
                        </div>
                        @endforeach
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Next</span>
                </a>
    </div>
    --}}
{{--Slider--}}{{--

    <hr>
    <div class="row">
        {!! $event->content !!}
    </div>
    <hr>
    @if(count($event->comments) > 0)
        <hr>
        @foreach($event->comments as $comment)
            @if(0 !== $comment->parent_id)
                @continue
            @endif
            <div class="row">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>{{ $comment->id }}</th>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>{{ $comment->email }}</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>{{ $comment->name }}</td>
                    </tr>
                    <tr>
                        <td>Коментарий</td>
                        <td>{{ $comment->text }}</td>
                    </tr>
                </table>
            </div>
            @include('comment', ['children' => $event->comments, 'id' => $comment->id])
        @endforeach
    @endif
    <hr>
    --}}
