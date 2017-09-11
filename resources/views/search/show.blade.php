<!--section 1-->
<section id="section-1" class="horoscope">
    <div class="left-title left-title-planshet">
        <div class="line-container text-vertical">
            <div class="vertical-line
            @if(session()->has('doc')) line-purple @endif
            "></div>
            <h2>Поиск</h2>
        </div>
    </div>
    <div class="content content-vnutrennaya">
        <div class="main-content">
            <div class="content-centr">
                {!! Form::open(['url'=>route('search'), 'method'=>'get']) !!}
                    <div class="form-search">
                        <input type="search" name="value" placeholder="введите ваш запрос">
                        <img src="{{ asset('estet') }}/img/menu/search.png" alt="">
                    </div>

                        <div class="result-search">
                            <p>Результаты поиска</p>
                            @if(!empty($titles) && $titles->total())
                            <span>
                                    {{ $titles->total()}}
                            </span>
                            @endif
                        </div>
                        <div class="concurrences">
                            <div class="concurrences-line">
                                <p>Совпадение</p>
                            </div>
                        </div>
                        <div class="concurrences-select">
                            <div class="blog-categories">
                                <div class="select select-blue select-black">
                                    <div class="form-select">
                                        <div>
                                            <input id="radio1" name="coincidence" type="radio" value="all">
                                            <label for="radio1">Все слова</label>
                                        </div>
                                        <div>
                                            <input id="radio2" name="coincidence" type="radio" value="any" checked>
                                            <label for="radio2">Любое из слов</label>
                                        </div>
                                        <div>
                                            <input id="radio3" name="coincidence" type="radio" value="exact" >
                                            <label for="radio3">Точное совпадение</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="select-input-concurrences">
                                    <p>порядок</p>
                                        {!!
                                            Form::select('order',
                                                ['Новые первыми', 'Старые первыми', 'По алфавиту', 'По популярности'],
                                                old('order') ? : '')
                                        !!}
                                    </span>

                        </div>
                        <div class="search-scope">
                            <div class="concurrences-1">
                                <div class="concurrences-line-1">
                                    <p>Ограничение области поиска</p>
                                </div>
                            </div>
                            <div class="search-scope-horizontal blog-categories">
                                <div class="search-scope-select select">

                                    <div class="select-left select-black">
                                        <div class="item2">
                                            <input id="radio4" name="doctor" type="checkbox" value="doctor">
                                            <label for="radio4">Статьи для докторов</label>
                                        </div>
                                        <div class="item2">
                                            <input id="radio5" name="patient" type="checkbox" value="patient">
                                            <label for="radio5">Статьи для читателей</label>
                                        </div>
                                    </div>
                                    <div class="select-right select-black">
                                        <div class="item1">
                                            <input id="radio7" name="blog" type="checkbox" value="blog">
                                            <label for="radio7">Блог</label>
                                        </div>
                                        <div class="item1">
                                            <input id="radio6" name="catalog" type="checkbox" value="catalog">
                                            <label for="radio6">Каталог</label>
                                        </div>
                                    </div>
                                    <div class="select-kategorii">
                                        <span class="select-search-scope">
                                            <p>Категории статей</p>
                                            {!! Form::select('categories', [null => 'Категория'] + $cats ?? [], old('categories') ? : '') !!}
                                        </span>
                                        <span class="select-search-scope">
                                            <p>количество строк</p>
                                            {!! Form::select('limit', ['20', '50', '100'], old('limit') ? : '') !!}
                                        </span>

                                    </div>
                                </div>
                            </div>

                        </div>
                {!! Form::close() !!}
                @if(!empty($titles))
                    <div class="row">
                        @if(!empty($titles->lastPage()) && $titles->lastPage() >1)
                            <div class="page-pagination">
                                <p>Страница<span class="start">{{ $titles->currentPage() }}</span>из<span class="end">{{ $titles->lastPage() }}</span></p>
                            </div>
                        @endif

                        @foreach($titles as $title)
                        <div class="link-center">
                            <div class="item">
                                <div class="item-number">
                                    <span>{{ $loop->iteration }}</span>
                                </div>
                                <div class="item-description">
                                    <a href="{{ $title->path ?? '#' }}">
                                        {{ $title->title }}
                                    </a>
                                    <p>{{ $title->created }} года.</p>{{$title->view}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="pagination content-blog">
                        <!--PAGINATION-->
                        <div class="pagination-blog">
                            @if($titles->lastPage() > 1)
                                <ul>
                                    @if($titles->currentPage() !== 1)
                                        <li>
                                            <a rel="prev" href="{{ $titles->url(($titles->currentPage() - 1)) }}" class="prev">
                                                <
                                            </a>
                                        </li>
                                    @endif
                                    @if($titles->currentPage() >= 3)
                                        <li><a href="{{ $titles->url($titles->lastPage()) }}">1</a></li>
                                    @endif
                                    @if($titles->currentPage() >= 4)
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($titles->currentPage() !== 1)
                                        <li>
                                            <a href="{{ $titles->url($titles->currentPage()-1) }}">{{ $titles->currentPage()-1 }}</a>
                                        </li>
                                    @endif
                                    <li><a class="active disabled">{{ $titles->currentPage() }}</a></li>
                                    @if($titles->currentPage() !== $titles->lastPage())
                                        <li>
                                            <a href="{{ $titles->url($titles->currentPage()+1) }}">{{ $titles->currentPage()+1 }}</a>
                                        </li>
                                    @endif
                                    @if($titles->currentPage() <= ($titles->lastPage()-3))
                                        <li><a href="#">...</a></li>
                                    @endif
                                    @if($titles->currentPage() <= ($titles->lastPage()-2))
                                        <li><a href="{{ $titles->url($titles->lastPage()) }}">{{ $titles->lastPage() }}</a></li>
                                    @endif
                                    @if($titles->currentPage() !== $titles->lastPage())
                                        <li>
                                            <a rel="next" href="{{ $titles->url(($titles->currentPage() + 1)) }}" class="next">
                                                >
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {!! $sidebar !!}
    </div>
</section>