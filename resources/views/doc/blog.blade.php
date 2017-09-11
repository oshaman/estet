<!--section 1-->
<section id="section-1" class="blog-page blog-vnutrenyyaya">
    <div class="left-title">
        <div class="line-container text-vertical">
            <div class="vertical-line line-purple"></div>
            <h2>Блог</h2>
        </div>
    </div>
    <div class="content">
        <div class="main-content">
            <!-- section-2 -->
            <section id="section-2" class="profile-blog">

                <div class="blog-profile">
                    <img src="{{asset('/estet/img/profile') . '/' . $blog->person->person->photo }}"
                         alt="{{ $blog->person->person->photo_alt ?? $blog->person->person->lastname . ' ' . $blog->person->person->name }} "
                         title="{{ $blog->person->person->photo_title ?? $blog->person->person->lastname . ' ' . $blog->person->person->name}} "
                    >
                    <div class="title-time">
                        <time>
                            @if(strlen($blog->created) < 6) <i class="icons icon-clock"></i> @endif
                            {{ $blog->created }}
                        </time>
                    </div>
                    <div class="name">
                        <p>
                            {{ $blog->person->person->lastname }}
                            <br>
                            {{ $blog->person->person->name }}
                        </p>
                    </div>
                    <div class="specialty">
                        <p>{{ $blog->person->person->specialties->implode('name', ', ') ?? '' }}</p>
                    </div>
                    <div class="achievements">
                        <p>{{ $blog->person->person->category }}</p>
                    </div>
                </div>
                <div class="blog-image">
                    <img src="{{asset('/images/blog/main') . '/' . $blog->blog_img->path}}"
                         alt="{{ $blog->blog_img->alt }}" title="{{ $blog->blog_img->title }}">
                </div>

            </section>
            <!-- section-3 -->
            <div class="blog-text">
                <h3>{{ $blog->title }}</h3>
                <div class="blog-post">
                    {!! $blog->content !!}
                </div>

            </div>
            <!-- section-4 -->
            <div class="blog-categories">

                <div class="select">

                    @foreach($blog->tags as $tag)
                        <a href="{{ route('blog_tag',['tag_alias'=> $tag->alias]) }}">{{ $tag->name }}</a>
                    @endforeach

                </div>

            </div>
            <!-- section-5 -->
            <div class="comment-post">
                <div class="social-networks">
                    <p>Добавьте в закладки чтобы не потерять / поделитесь с друзьями:</p>
                    <div class="social-post">
                        <img src="{{asset('estet')}}/img/social/1.png" alt="">
                        <img src="{{asset('estet')}}/img/social/2.png" alt="">
                        <img src="{{asset('estet')}}/img/social/3.png" alt="">
                        <img src="{{asset('estet')}}/img/social/3.png" alt="">
                        <img src="{{asset('estet')}}/img/social/3.png" alt="">
                        <img src="{{asset('estet')}}/img/social/6.png" alt="">
                    </div>
                </div>
                {{--comments--}}
                {{--@if(count($blog->comments) > 0)
                    <hr>
                    @foreach($blog->comments as $comment)
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
                        @include('comment', ['children' => $blog->comments, 'id' => $comment->id])
                    @endforeach
                @endif
                <hr>--}}

                <div class="section-form">
                    <p class="add-comm">Добавить коментарий:</p>
                    {!! Form::open(['url' => route('comments'),'class'=>'section-form-up','method'=>'post']) !!}
                    <input type="email" name="email" class="section-input" placeholder="ваша почта"
                           value="{{ old('email') ? : '' }}">
                    <input type="text" name="name" class="section-input" placeholder="имя"
                           value="{{ old('name') ? : '' }}">
                    <textarea name="text" cols="40" rows="3" class="section-form-text"
                              placeholder="текст">{{ old('text') ? : '' }}</textarea>
                    <div class="section-form-down">
                        <div>
                            <input readonly type="text" name="cod" class="section-form-test" placeholder="78535">
                            <input type="text" name="prof" class="section-form-test">
                        </div>
                        <button class="but-section-form but-section-purpur" type="button">отправить</button>
                    </div>
                    <p><img src="{{asset('estet')}}/img/content/refresh.png" alt="">обновить</p>
                    {{ Form::hidden('comment_post_ID', $blog->id) }}
                    {{ Form::hidden('comment_parent', 0) }}
                    {{ Form::hidden('comment_source', 2) }}
                    {!! Form::close() !!}
                </div>
            </div>


        </div>
        {!! $sidebar !!}
    </div>
</section>
<!--section 4-->
<section id="section-4" class="blog-similar-articles">
    <div class="left-title">
        <div class="line-container">
            <div class="vertical-line line-purple"></div>
            <h2>Похожие статьи</h2>
        </div>
    </div>
    <div class="content content-blog">
        <div class="articles-horizontal">
            @foreach($blogs as $blog)
                <article>
                    <a class="link-img" href="{{ route('blogs',['blog'=> $blog->alias]) }}" rel="nofollow">
                        <img src="{{ asset('/images/blog/small') . '/' . $blog->blog_img->path }}"
                             alt="{{ $blog->blog_img->alt }}" title="{{ $blog->blog_img->title }}">
                    </a>
                    <div class="title-time">
                        <time>
                            @if(strlen($blog->created) < 6) <i class="icons icon-clock"></i> @endif
                            {{ $blog->created }}
                        </time>
                        <p>{{ $blog->category->name }}</p>
                    </div>
                    <a class="link-title" href="{{ route('blogs',['blog'=> $blog->alias]) }}">
                        <h3>{{ $blog->title }}</h3>
                    </a>
                    <div class="blog-read-more">
                        <div class="author">
                            <i class="icon-men"></i>
                            <p>{{ $blog->person->person->name . ' ' . $blog->person->person->lastname }}</p>
                        </div>
                        <div class="button-read-more">
                            <a href="{{ route('blogs',['blog'=> $blog->alias]) }}">Подробнее</a>
                    </div>
                </div>
                </article>
            @endforeach
        </div>
    </div>
</section>