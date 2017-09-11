<h1>Редактирование города</h1>

{!! Form::open(['url' => route('edit_city', $city->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    <div class="row">
        {{ Form::label('country', 'Страна') }}
        {!! Form::select('country', $countries, old('country') ? : ($city->country_id), ['class'=>'form-control']) !!}
    </div>
    {{ Form::label('city', 'Название') }}
    <div class="row">
        {!! Form::text('city', old('city') ? : ($city->name ?? '') , ['placeholder'=>'Зимбабве...', 'id'=>'city', 'class'=>'form-control']) !!}
    </div>
    <hr>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>