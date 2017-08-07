<h1>Редактирование категории</h1>

{!! Form::open(['url' => route('edit_tags', $tag->id), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('tag', 'Название категории') }}
    <div class="row">
        {!! Form::text('tag', old('tag') ? : ($tag->name ?? '') , ['placeholder'=>'Психиатрия...', 'id'=>'tag', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::text('alias', old('alias') ? : ($tag->alias ?? '') , ['placeholder'=>'psihiatr...', 'id'=>'cat', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.edit_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>