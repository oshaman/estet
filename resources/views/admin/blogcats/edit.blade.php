<h1>Редактирование категории</h1>

{!! Form::open(['url' => route('edit_blogcats', $category->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('cat', 'Название категории') }}
    <div class="row">
        {!! Form::text('cat', old('cat') ? : ($category->name ?? '') , ['placeholder'=>'Психиатрия...', 'id'=>'cat', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>