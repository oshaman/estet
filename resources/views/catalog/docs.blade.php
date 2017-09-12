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
                <span itemprop="title"></span>
            </div>
        </div>
        <div class="katalog-page">

            <div class="main-content page-content">
                <!-- section-3 -->
            @include('catalog.nav')
            <!-- section-4 -->
                <div class="articles-wrap">
                    {{--premium--}}
                    @if(!empty($prems))
                        @foreach($prems as $prem)
                            <div class="article premium">
                                <div class="article-content">
                                    <div class="article-content_top">
                                        <img src="{{ asset('/images/establishment/small') . '/' . $prem->logo  }}"
                                             alt="{{ $prem->alt ?? '' }}" title="{{ $prem->imgtitle ?? '' }}">
                                        <div>
                                            <h4>
                                                <span>{{ ($profile->name ?? '') . ' ' . ($profile->lastname ?? '')}}</span>
                                            </h4>
                                            <p>
                                                @if(!empty($prem->description))
                                                    {{ $prem->description }}
                                                @else
                                                    {!! str_limit($prem->content, 254) !!}
                                                @endif
                                            </p>
                                            <hr>
                                            <span>{{ $prem->address }}</span>
                                        </div>

                                    </div>
                                    <div class="button-block">
                                        <div class="button-line"></div>
                                        <a href="{{ route('profiles',['profile'=> $prem->alias]) }}">
                                            Подробнее о бренде
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{--premium--}}
                    {{--profiles--}}
                    @if(!empty($profiles))
                        @foreach($profiles as $profile)
                            <div class="article">
                                <div class="article-content">
                                    <div class="article-content_top">
                                        <img src="{{ asset('/images/establishment/main') . '/' . $profile->logo }}"
                                             alt="{{ $profile->alt ?? '' }}" title="{{ $profile->imgtitle ?? '' }}">
                                        <div>
                                            <h4><span>{{ $profile->title }}</span></h4>
                                            <p>
                                                @if(!empty($profile->description))
                                                    {{ $profile->description }}
                                                @else
                                                    {!! str_limit($profile->content, 254) !!}
                                                @endif
                                            </p>
                                            <hr>
                                            <span>{{ $profile->address }}</span>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <div class="button-line"></div>
                                        <a href="route('profiles',['profile'=> $profile->alias])">
                                            Подробнее о бренде
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{--profiles--}}
                    <hr>
                    <div class="pagination content-blog">
                        <!--PAGINATION-->
                        <div class="pagination-blog">
                            @if($profiles->lastPage() > 1)
                                <ul>
                                    @if($profiles->currentPage() !== 1)
                                        <li>
                                            <a rel="prev" href="{{ $profiles->url(($profiles->currentPage() - 1)) }}"
                                               class="prev">
                                                <
                                            </a>
                                        </li>
                                    @endif
                                    @if($profiles->currentPage() >= 3)
                                        <li><a href="{{ $profiles->url($profiles->lastPage()) }}">1</a></li>
                                    @endif
                                    @if($profiles->currentPage() >= 4)
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($profiles->currentPage() !== 1)
                                        <li>
                                            <a href="{{ $profiles->url($profiles->currentPage()-1) }}">{{ $profiles->currentPage()-1 }}</a>
                                        </li>
                                    @endif
                                    <li><a class="active disabled">{{ $profiles->currentPage() }}</a></li>
                                    @if($profiles->currentPage() !== $profiles->lastPage())
                                        <li>
                                            <a href="{{ $profiles->url($profiles->currentPage()+1) }}">{{ $profiles->currentPage()+1 }}</a>
                                        </li>
                                    @endif
                                    @if($profiles->currentPage() <= ($profiles->lastPage()-3))
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($profiles->currentPage() <= ($profiles->lastPage()-2))
                                        <li>
                                            <a href="{{ $profiles->url($profiles->lastPage()) }}">{{ $profiles->lastPage() }}</a>
                                        </li>
                                    @endif
                                    @if($profiles->currentPage() !== $profiles->lastPage())
                                        <li>
                                            <a rel="next" href="{{ $profiles->url(($profiles->currentPage() + 1)) }}"
                                               class="next">
                                                >
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
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
        {!! $sidebar !!}
    </div>
</section>


{{--
@if (!empty($profiles))
    @foreach($profiles as $profile)
        <div class="row">
            <div class="col-xs-8">
                <div class="row">
                    <h3>{{ ($profile->name ?? '') . ' ' . ($profile->lastname ?? '')}}</h3>
                    <hr>
                </div>
                <div class="row">
                    <h4>{{ $profile->specialties->implode('name', ', ') ?? ''}}</h4>
                    <hr>
                    @if(!empty($profile->address))
                        <h4>{{ $profile->address}}</h4>
                    @endif
                    @if(!empty($profile->job))
                        <h4>{{ $profile->job ?? ''}}</h4>
                    @endif
                    <h4>{{ $profile->phone ?? ''}}</h4>
                    <h4>{{ $profile->site ?? ''}}</h4>
                    <hr>
                </div>
            </div>
            <div class="col-xs-3">
                <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
            </div>
        </div>
        <div class="row">
            {!! Form::open(['url' => route('docs', $profile->alias), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
            {!! Form::button('Подробнее о ' . trans('ru.doce'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    @endforeach

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($profiles->lastPage() > 1)
            <ul class="pagination">
                @if($profiles->currentPage() !== 1)
                    <li><a href="{{ $profiles->url(($profiles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $profiles->lastPage(); $i++)
                    @if($profiles->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $profiles->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($profiles->currentPage() !== $profiles->lastPage())
                    <li><a href="{{ $profiles->url(($profiles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif--}}
