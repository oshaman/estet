<h1>Добавление страны</h1>

<div class="row">
    {!! Form::open(['url' => route('create_country'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    {{ Form::label('name', 'Страна') }}
    <div class="row">
        {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Никарагуа...', 'id'=>'name', 'class'=>'form-control']) !!}
    </div>
    <hr>
    <div class="row">
        {!! Form::button(trans('admin.add_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>