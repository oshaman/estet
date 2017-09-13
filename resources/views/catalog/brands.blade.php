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
            </div>/
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
                                        <a href="{{ route('brands',['brand'=> $prem->alias]) }}">
                                            Подробнее о бренде
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{--premium--}}
                    {{--brands--}}
                    @if(!empty($brands))
                        @foreach($brands as $brand)
                            <div class="article">
                                <div class="article-content">
                                    <div class="article-content_top">
                                        <img src="{{ asset('/images/establishment/main') . '/' . $brand->logo }}"
                                             alt="{{ $brand->alt ?? '' }}" title="{{ $brand->imgtitle ?? '' }}">
                                        <div>
                                            <h4><span>{{ $brand->title }}</span></h4>
                                            <p>
                                                @if(!empty($brand->description))
                                                    {{ $brand->description }}
                                                @else
                                                    {!! str_limit($brand->content, 254) !!}
                                                @endif
                                            </p>
                                            <hr>
                                            <span>{{ $brand->address }}</span>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <div class="button-line"></div>
                                        <a href="{{ route('brands',['brand'=> $brand->alias]) }}">
                                            Подробнее о бренде
                                        </a>
                                </div>
                            </div>
                            </div>
                        @endforeach
                    @endif
                    {{--brands--}}
                    <hr>
                    <div class="pagination content-blog">
                        <!--PAGINATION-->
                        <div class="pagination-blog">
                            @if($brands->lastPage() > 1)
                                <ul>
                                    @if($brands->currentPage() !== 1)
                                        <li>
                                            <a rel="prev" href="{{ $brands->url(($brands->currentPage() - 1)) }}"
                                               class="prev">
                                                <
                                            </a>
                                        </li>
                                    @endif
                                    @if($brands->currentPage() >= 3)
                                        <li><a href="{{ $brands->url(1) }}">1</a></li>
                                    @endif
                                    @if($brands->currentPage() >= 4)
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($brands->currentPage() !== 1)
                                        <li>
                                            <a href="{{ $brands->url($brands->currentPage()-1) }}">{{ $brands->currentPage()-1 }}</a>
                                        </li>
                                    @endif
                                    <li><a class="active disabled">{{ $brands->currentPage() }}</a></li>
                                    @if($brands->currentPage() !== $brands->lastPage())
                                        <li>
                                            <a href="{{ $brands->url($brands->currentPage()+1) }}">{{ $brands->currentPage()+1 }}</a>
                                        </li>
                                    @endif
                                    @if($brands->currentPage() <= ($brands->lastPage()-3))
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($brands->currentPage() <= ($brands->lastPage()-2))
                                        <li>
                                            <a href="{{ $brands->url($brands->lastPage()) }}">{{ $brands->lastPage() }}</a>
                                        </li>
                                    @endif
                                    @if($brands->currentPage() !== $brands->lastPage())
                                        <li>
                                            <a rel="next" href="{{ $brands->url(($brands->currentPage() + 1)) }}"
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