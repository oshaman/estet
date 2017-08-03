@if(!empty($articles))
    @foreach($articles as $article)
        <div class="row">
            <div class="col-md-6">
                {{ Html::image(asset('/images/article/main') . '/' . $article->image->path, $article->image->alt, ['title' => $article->image->title]) }}
            </div>
            <div class="col-md-6">
                <div class="row">
                    <span>{{ $article->category->name }}</span> <span class="label label-default">{{ $article->created }}</span>
                </div>
                <h2>{{ $article->title }}</h2>
                <p>
                    {!! Form::open(['url' => route('articles',['article'=> $article->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </p>
                @foreach($article->tags as $tag)
                    <span class="label label-info">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    @endforeach
    <!--PAGINATION-->
    {{--<div class="general-pagination group">
        @if($articles->lastPage() > 1)
            <ul class="pagination">
                @if($articles->currentPage() !== 1)
                    <li><a href="{{ $articles->url(($articles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $articles->lastPage(); $i++)
                    @if($articles->currentPage() == $i)
                        <li><a class="active disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($articles->currentPage() !== $articles->lastPage())
                    <li><a href="{{ $articles->url(($articles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>
        @endif
    </div>--}}
@endif