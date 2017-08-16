<h1>Добавление города</h1>
{!! Form::open(['url' => route('create_city'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('country', 'Выбрать страну') }}
    {!! Form::select('country', $countries, old('country') ? : '', ['class'=>'form-control']) !!}
</div>
<hr>
<div class="row">
    {{ Form::label('name', 'Название города') }}
    <div class="row">
        {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Токио...', 'id'=>'name', 'class'=>'form-control']) !!}
    </div>
    <hr>
    <div class="row">
        {!! Form::button(trans('admin.add_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>