<h1>Редактирование организатора</h1>

{!! Form::open(['url' => route('organizer_edit', $organizer->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('organizer', 'Название категории') }}
    <div class="row">
        {!! Form::text('organizer', old('organizer') ? : ($organizer->name ?? '') , ['placeholder'=>'Название...', 'id'=>'organizer', 'class'=>'form-control']) !!}
    </div>
    {{ Form::label('alias', 'Псевдоним') }}
    <div class="row">
        {!! Form::text('alias', old('alias') ? : ($organizer->alias ?? '') , ['placeholder'=>'psihiatr...', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
    {{ Form::label('parent', 'ID родителя') }}
    <div class="row">
        {!! Form::text('parent', old('parent') ? : ($organizer->parent ?? '') , ['placeholder'=>'ID', 'id'=>'parent', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>