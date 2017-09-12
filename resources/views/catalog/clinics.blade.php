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
                    <span itemprop="title">Бренды и их представители</span>
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
                                            <h4><span>{{ $prem->title }}</span></h4>
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
                                        <a href="{{ route('clinics',['clinic'=> $prem->alias]) }}">
                                            Подробнее о бренде
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{--premium--}}
                    {{--clinics--}}
                    @if(!empty($clinics))
                        @foreach($clinics as $clinic)
                            <div class="article">
                                <div class="article-content">
                                    <div class="article-content_top">
                                        <img src="{{ asset('/images/establishment/main') . '/' . $clinic->logo }}"
                                             alt="{{ $clinic->alt ?? '' }}" title="{{ $clinic->imgtitle ?? '' }}">
                                        <div>
                                            <h4><span>{{ $clinic->title }}</span></h4>
                                            <p>
                                                @if(!empty($clinic->description))
                                                    {{ $clinic->description }}
                                                @else
                                                    {!! str_limit($clinic->content, 254) !!}
                                                @endif
                                            </p>
                                            <hr>
                                            <span>{{ $clinic->address }}</span>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <div class="button-line"></div>
                                        <a href="route('clinics',['clinic'=> $clinic->alias])">
                                            Подробнее о бренде
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{--clinics--}}
                    <hr>
                    <div class="pagination content-blog">
                        <!--PAGINATION-->
                        <div class="pagination-blog">
                            @if($clinics->lastPage() > 1)
                                <ul>
                                    @if($clinics->currentPage() !== 1)
                                        <li>
                                            <a rel="prev" href="{{ $clinics->url(($clinics->currentPage() - 1)) }}"
                                               class="prev">
                                                <
                                            </a>
                                        </li>
                                    @endif
                                    @if($clinics->currentPage() >= 3)
                                        <li><a href="{{ $clinics->url($clinics->lastPage()) }}">1</a></li>
                                    @endif
                                    @if($clinics->currentPage() >= 4)
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($clinics->currentPage() !== 1)
                                        <li>
                                            <a href="{{ $clinics->url($clinics->currentPage()-1) }}">{{ $clinics->currentPage()-1 }}</a>
                                        </li>
                                    @endif
                                    <li><a class="active disabled">{{ $clinics->currentPage() }}</a></li>
                                    @if($clinics->currentPage() !== $clinics->lastPage())
                                        <li>
                                            <a href="{{ $clinics->url($clinics->currentPage()+1) }}">{{ $clinics->currentPage()+1 }}</a>
                                        </li>
                                    @endif
                                    @if($clinics->currentPage() <= ($clinics->lastPage()-3))
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($clinics->currentPage() <= ($clinics->lastPage()-2))
                                        <li>
                                            <a href="{{ $clinics->url($clinics->lastPage()) }}">{{ $clinics->lastPage() }}</a>
                                        </li>
                                    @endif
                                    @if($clinics->currentPage() !== $clinics->lastPage())
                                        <li>
                                            <a rel="next" href="{{ $clinics->url(($clinics->currentPage() + 1)) }}"
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