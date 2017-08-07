<div class="col-lg-9">
    <h2>{{ $article->title }}</h2>
    <div class="row">
        {{ Html::image(asset('/images/article/main') . '/' . $article->image->path, $article->image->alt, ['title' => $article->image->title]) }}
    </div>
    <div class="row">
        <div class="row">
            <a href="{{ route('article_cat', $article->category->alias) }}"><span>{{ $article->category->name }}</span></a> <span class="label label-default">{{ $article->created }}</span>
        </div>
        <div class="row">{!! $article->content !!}</div>
    </div>
    <hr>
    <div class="row btn-group">
        @foreach($article->tags as $tag)
            {!! Form::open(['url' => route('articles_tag',['article'=> $tag->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
            {!! Form::button($tag->name, ['class' => 'btn btn-info btn-xs','type'=>'submit']) !!}
            {!! Form::close() !!}
        @endforeach
    </div>
</div>
<div class="col-lg-3">
    <div class="row">
        <h3>Последние статьи</h3>
    @foreach($lasts as $last)
        <div class="row">
            <p><span class="label label-default">{{ $last->created }}</span></p>
            <p><a href="{{ route('articles', $last->alias) }}"> {{ $last->title }}</a></p>
        </div>
    @endforeach
    </div>
    <hr>
    <div class="row">
        <h3>Самое популярное</h3>
    </div>
</div>
