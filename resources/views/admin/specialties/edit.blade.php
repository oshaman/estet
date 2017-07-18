<h1>Редактирование специальности</h1>

{!! Form::open(['url' => route('edit_specialties', $specialty->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('spec', 'Название специальности') }}
    <div class="row">
        {!! Form::text('spec', old('spec') ? : ($specialty->name ?? '') , ['placeholder'=>'Психиатр...', 'id'=>'spec', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>