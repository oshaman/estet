<div class="col-lg-9">
@if(!empty($articles))
    @foreach($articles as $article)
        <div class="row">
            <div class="col-md-6">
                {{ Html::image(asset('/images/article/middle') . '/' . $article->image->path, $article->image->alt, ['title' => $article->image->title]) }}
            </div>
            <div class="col-md-6">
                <div class="row">
                    <a href="{{ route('docs_cat', $article->category->alias) }}"><span>{{ $article->category->name }}</span></a> <span class="label label-default">{{ $article->created }}</span>
                </div>
                <h2>{{ $article->title }}</h2>
                <div class="row">{!! str_limit($article->content, 600) !!}</div>
                <p>
                    {!! Form::open(['url' => route('doctors',['article'=> $article->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </p>
            </div>
        </div>
    @endforeach
@endif
</div>
<div class="col-lg-2 col-lg-offset-1">
    @if(!empty($sidebar))
        {!! $sidebar !!}
    @endif
</div>