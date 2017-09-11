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
    @if(count($article->comments) > 0)
        <hr>
        @foreach($article->comments as $comment)
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
            @include('comment', ['children' => $article->comments, 'id' => $comment->id])
        @endforeach
    @endif
    <hr>
    <div class="row">
        <div class="captcha"><img id="captcha" src="{{ route('captcha') }}"></div>
        <input type=button class="reload" value="Reload">
        <h4>Добавить коментарий</h4>
        <div class="row">
            {!! Form::open(['url' => route('comments'),'class'=>'form-horizontal','method'=>'post']) !!}
            {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Ваша почта', 'id'=>'email', 'class'=>'form-control']) !!}
            {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Имя', 'id'=>'name', 'class'=>'form-control']) !!}
            {!! Form::textarea('text', old('text') ? : '' , ['placeholder'=>'Коментарий', 'id'=>'text', 'class'=>'form-control', 'rows'=>5, 'cols'=>50]) !!}
            {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
            {{ Form::hidden('comment_post_ID', $article->id) }}
            {{ Form::hidden('comment_parent', 0) }}
            {{ Form::hidden('comment_source', 1) }}
            {!! Form::close() !!}
        </div>
    </div>
    <hr>
</div>
<div class="col-lg-3">
    @if(!empty($sidebar))
        {!! $sidebar !!}
    @endif
</div>
