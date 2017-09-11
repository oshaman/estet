<div class="row">
    <h3>Последние статьи</h3>
    @if($lasts)
        @foreach($lasts as $last)
            <div class="row">
                <p><span class="label label-default">{{ $last->created }}</span></p>
                <p><a href="{{ route('doctors', $last->alias) }}"> {{ $last->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>
<hr>
<div class="row">
    <h3>Самое популярное</h3>
    @if($articles)
        @foreach($articles as $article)
            <div class="row">
                <p><span class="label label-default">{{ $article->created }}</span></p>
                <p><a href="{{ route('doctors', $article->alias) }}"> {{ $article->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>
<div class="row">
    <h3>Подписаться на рассылку</h3>
    {!! Form::open(['url'=>route('subscribe')]) !!}
    {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Email', 'id'=>'email', 'class'=>'form-control']) !!}
    <div class="row">
        {{ Form::label('status', 'Принадлежность') }}
        <div>
            {!! Form::select('status', [0=>'Пациент', 1=>'Доктор'],
                old('status') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Доктор\Пациент'])
            !!}
        </div>
        <hr>
        {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>