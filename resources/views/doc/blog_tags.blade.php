<section id="section-1" class="horoscope">
    <div class="left-title left-title-planshet ">
        <div class="line-container text-vertical">
            <div class="vertical-line"></div>
            <h2>{{ $tag->name }}</h2>
        </div>
    </div>
    <div class="content">
        <div class="main-content">
            @if($blogs)
                @foreach($blogs as $blog)
                    @if($loop->iteration%2 !== 0)
                        <div class="statyi-content">
                            <div class="statyi-block">
                                <div class="img-statyi">
                                    <img src="{{ asset('/images/blog/small').'/'.$blog->blog_img->path }}"
                                         alt="{{$blog->blog_img->alt}}" title="{{ $blog->blog_img->title }}">
                                </div>
                                <div class="block-text">
                        <span>
                            @if(strlen($blog->created) < 6) <i class="icons icon-clock"></i> @endif
                            {{ $blog->created }}
                        </span>
                                    <a href="{{ route('blogs', $blog->alias) }}">
                                        <p>{{ $blog->title }}</p>
                                    </a>
                                </div>
                            </div>
                            @if($loop->last)
                        </div>
                    @endif
                    @else
                        <div class="statyi-block">
                            <div class="img-statyi">
                                <img src="{{ asset('/images/blog/small').'/'.$blog->blog_img->path }}"
                                     alt="{{$blog->blog_img->alt}}" title="{{ $blog->blog_img->title }}">
                            </div>
                            <div class="block-text">
                    <span>
                        @if(strlen($blog->created) < 6) <i class="icons icon-clock"></i> @endif
                        {{ $blog->created }}
                    </span>
                                <a href="{{ route('blogs', $blog->alias) }}">
                                    <p>{{ $blog->title }}</p>
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
            @if($blogs->lastPage() > 1)
                <ul>
                    @if($blogs->currentPage() !== 1)
                        <li>
                            <a rel="prev" href="{{ $blogs->url(($blogs->currentPage() - 1)) }}" class="prev">
                                <
                            </a>
                        </li>
                    @endif
                    @if($blogs->currentPage() >= 3)
                        <li><a href="{{ $blogs->url($blogs->lastPage()) }}">1</a></li>
                    @endif
                    @if($blogs->currentPage() >= 4)
                        <li><a href="#">...</a></li>
                    @endif
                    @if($blogs->currentPage() !== 1)
                        <li>
                            <a href="{{ $blogs->url($blogs->currentPage()-1) }}">{{ $blogs->currentPage()-1 }}</a>
                        </li>
                    @endif
                    <li><a class="active disabled">{{ $blogs->currentPage() }}</a></li>
                    @if($blogs->currentPage() !== $blogs->lastPage())
                        <li>
                            <a href="{{ $blogs->url($blogs->currentPage()+1) }}">{{ $blogs->currentPage()+1 }}</a>
                        </li>
                    @endif
                    @if($blogs->currentPage() <= ($blogs->lastPage()-3))
                        <li><a href="#">...</a></li>
                    @endif
                    @if($blogs->currentPage() <= ($blogs->lastPage()-2))
                        <li><a href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a></li>
                    @endif
                    @if($blogs->currentPage() !== $blogs->lastPage())
                        <li>
                            <a rel="next" href="{{ $blogs->url(($blogs->currentPage() + 1)) }}" class="next">
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