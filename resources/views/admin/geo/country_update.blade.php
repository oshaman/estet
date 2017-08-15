<h1>Редактирование страны</h1>

{!! Form::open(['url' => route('edit_country', $country->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('country', 'Название') }}
    <div class="row">
        {!! Form::text('country', old('country') ? : ($country->name ?? '') , ['placeholder'=>'Зимбабве...', 'id'=>'country', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>