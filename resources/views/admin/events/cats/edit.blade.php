<h1>Редактирование категории</h1>

{!! Form::open(['url' => route('eventcats_edit', $category->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('eventcat', 'Название категории') }}
    <div class="row">
        {!! Form::text('eventcat', old('eventcat') ? : ($category->name ?? '') , ['placeholder'=>'Психиатр...', 'id'=>'eventcat', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::text('alias', old('alias') ? : ($category->alias ?? '') , ['placeholder'=>'psihiatr...', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>