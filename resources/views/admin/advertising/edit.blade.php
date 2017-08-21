<h2>Редактирование Рекламы</h2>
<hr>
{!! Form::open(['url'=>route('advertising_update', $advertising->id), 'method'=>'post', 'class'=>'form-horizontal']) !!}
<div class="row">
    <div class="row">
        {{ Form::label('text', 'Контент') }}
        <div>
            {!! Form::textarea('text', old('text') ? : ($advertising->text ?? '') , ['placeholder'=>'text', 'id'=>'text', 'class'=>'form-control']) !!}
        </div>
    </div>
</div>
{!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
{!! Form::close() !!}