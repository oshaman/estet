<section id="section-1" class="horoscope">
    <div class="left-title left-title-planshet ">
        <div class="line-container text-vertical">
            <div class="vertical-line"></div>
            <h2>{{ $tag->name }}</h2>
        </div>
    </div>
    <div class="content">
        <div class="main-content">
            @if($articles)
                @foreach($articles as $article)
                    @if($loop->iteration%2 !== 0)
                        <div class="statyi-content">
                            <div class="statyi-block">
                                <div class="img-statyi">
                                    <img src="{{ asset('/images/article/small').'/'.$article->image->path }}"
                                         alt="{{$article->image->alt}}" title="{{ $article->image->title }}">
                                </div>
                                <div class="block-text">
                        <span>
                            @if(strlen($article->created) < 6) <i class="icons icon-clock"></i> @endif
                            {{ $article->created }}
                        </span>
                                    <a href="{{ route('articles', $article->alias) }}">
                                        <p>{{ $article->title }}</p>
                                    </a>
                                </div>
                            </div>
                            @if($loop->last)
                        </div>
                    @endif
                    @else
                        <div class="statyi-block">
                            <div class="img-statyi">
                                <img src="{{ asset('/images/article/small').'/'.$article->image->path }}"
                                     alt="{{$article->image->alt}}" title="{{ $article->image->title }}">
                            </div>
                            <div class="block-text">
                    <span>
                        @if(strlen($article->created) < 6) <i class="icons icon-clock"></i> @endif
                        {{ $article->created }}
                    </span>
                                <a href="{{ route('articles', $article->alias) }}">
                                    <p>{{ $article->title }}</p>
                                </a>
                            </div>
                        </div>
        </div>
        @endif
        @endforeach
        @endif
    </div>
    {!! $sidebar !!}
    <div class="pagination content-blog">
        <!--PAGINATION-->
        <div class="pagination-blog">
            @if($articles->lastPage() > 1)
                <ul>
                    @if($articles->currentPage() !== 1)
                        <li>
                            <a rel="prev" href="{{ $articles->url(($articles->currentPage() - 1)) }}" class="prev">
                                <
                            </a>
                        </li>
                    @endif
                    @if($articles->currentPage() >= 3)
                        <li><a href="{{ $articles->url($articles->lastPage()) }}">1</a></li>
                    @endif
                    @if($articles->currentPage() >= 4)
                        <li><a href="#">...</a></li>
                    @endif
                    @if($articles->currentPage() !== 1)
                        <li>
                            <a href="{{ $articles->url($articles->currentPage()-1) }}">{{ $articles->currentPage()-1 }}</a>
                        </li>
                    @endif
                    <li><a class="active disabled">{{ $articles->currentPage() }}</a></li>
                    @if($articles->currentPage() !== $articles->lastPage())
                        <li>
                            <a href="{{ $articles->url($articles->currentPage()+1) }}">{{ $articles->currentPage()+1 }}</a>
                        </li>
                    @endif
                    @if($articles->currentPage() <= ($articles->lastPage()-3))
                        <li><a href="#">...</a></li>
                    @endif
                    @if($articles->currentPage() <= ($articles->lastPage()-2))
                        <li><a href="{{ $articles->url($articles->lastPage()) }}">{{ $articles->lastPage() }}</a></li>
                    @endif
                    @if($articles->currentPage() !== $articles->lastPage())
                        <li>
                            <a rel="next" href="{{ $articles->url(($articles->currentPage() + 1)) }}" class="next">
                                >
                            </a>
                        </li>
                    @endif
                </ul>
            @endif
        </div>
    </div>
    </div>
</section>
<!---------------------------------------------about the rubrics start------------------------------------->
<div class="container container-rubrics">
    <div class="rubrics">
        <h3>О рубрике Каталог</h3>
        <p>
            Раздел «Мероприятия» позволяет всем заинтересованным в сфере эстетической медицины не пропустить
            медицинские
            мероприятия, которые помогут не только постоянно следить за мировыми и местными событиями,
            интересными для
            врачей-эстетистов и специалистов других отраслей медицины, но и позволят расширить базу знаний и
            завести новые
            знакомства, получить бесценный опыт и повысить свою квалификацию. Медицинские мероприятия для
            профессионалов
            включают в себя тренинги, практикумы, обучающие курсы, конференции, выставки и прочие события в мире
            медицины.
        </p>
    </div>
</div>
<!------------------------------------------------about the rubrics end------------------------------------------------>