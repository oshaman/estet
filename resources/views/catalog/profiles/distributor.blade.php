<h2>{{ trans('ru.distributors') }}-----------------------------------------------</h2>
<div class="row">
    <div class="col-lg-4">
        <div class="row">{{ Html::image(asset('/images/establishment/main') . '/' . $distributor->logo, $distributor->title, array('class' => 'img-thumbnail')) }}</div>
        <div class="d-block bg-info">
            <div><strong>Категория: </strong>{{ trans('ru.' .$distributor->category) }}</div>
            <div><strong>Телефоны: </strong>{{ $distributor->phones }}</div>
            <div><strong>Сайт: </strong>{{ $distributor->site }}</div>
            <hr>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#children">Дочерние бренды: </a>
                </h4>
            </div>
            @if(!empty($children))
                <div id="children" class="panel-collapse collapse">
                    @foreach($children as $child)
                        <div class="panel-body"><a href="{{ route('brands', $child->alias) }}">{{ $child->title }}</a></div>
                    @endforeach
                </div>
            @endif
            <hr>
            @if(!empty($distributor->services))
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#service">Категории товаров: </a>
                    </h4>
                </div>
                <div id="service" class="panel-collapse collapse">
                    @foreach($distributor->services as $service)
                        <div class="panel-body">{{ $service }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row"><h2 class="text-center">{{ $distributor->title }}</h2></div>
        <hr>
        <div class="row">{{ $distributor->address }}</div>
        <h3>О нас</h3>
        <div class="row">{!! $distributor->content !!}</div>
    </div>
    <hr>
</div>
<hr>
@if(!empty($distributor->articles))
    <div class="row bg-warning">
        <h4>Публикации дистрибьютора ========================================</h4>
        @foreach($distributor->articles as $article)
            <a href="{{ route('articles', $article->alias) }}">{{ $article->title }}</a>
            <hr>
        @endforeach
    </div>
@endif
@if(count($distributor->comments) > 0)
    <hr>
    @foreach($distributor->comments as $comment)
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
        @include('comment', ['children' => $distributor->comments, 'id' => $comment->id])
    @endforeach
@endif
<hr>
<div class="row">
    <h4>Добавить коментарий</h4>
    <div class="row">
        {!! Form::open(['url' => route('comments'),'class'=>'form-horizontal','method'=>'post']) !!}
        {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Ваша почта', 'id'=>'email', 'class'=>'form-control']) !!}
        {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Имя', 'id'=>'name', 'class'=>'form-control']) !!}
        {!! Form::textarea('text', old('text') ? : '' , ['placeholder'=>'Коментарий', 'id'=>'text', 'class'=>'form-control', 'rows'=>5, 'cols'=>50]) !!}
        {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {{ Form::hidden('comment_post_ID', $distributor->id) }}
        {{ Form::hidden('comment_parent', 0) }}
        {{ Form::hidden('comment_source', 3) }}
        {!! Form::close() !!}
    </div>
</div>
<hr>