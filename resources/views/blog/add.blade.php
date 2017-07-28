<h2>{{$content}}</h2>
{!! Form::open(['url'=>route('create_blog'), 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true]) !!}
{{ csrf_field() }}
<div class="row">
    {{ Form::label('title', 'Заголовок страницы') }}
    <div>
        {!! Form::text('title', old('title') ? : '' , ['placeholder'=>'Title', 'id'=>'title', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
        {{ Form::label('img', 'Основное изображение') }}
    <div>
        {!! Form::file('img', ['accept'=>'image/*', 'id'=>'img', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('cats', 'Категория') }}
    <div>
        {!! Form::select('cats', $cats ?? [],
            old('cats') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Категория'])
        !!}
    </div>
</div>
<div class="row">
    <!-- Moderated -->
    <label><input type="checkbox" {{ old('moder') ? 'checked' : ''}} value="1" name="moder"> Отправить модератору</label>
</div>
<div class="row">
    <textarea name="content" class="form-control editor">{!! old('content') ? : '' !!}</textarea>
    {!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
</div>
{!! Form::close() !!}
