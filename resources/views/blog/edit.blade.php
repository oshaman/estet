<h2>{{$content}}</h2>
@if(!empty($blog->moderate))
    <span class="label label-warning">Ваш пост на проверке у модератора</span>
@endif
@if(key_exists('blog_id',$blog->toArray()))
    {!! Form::open(['url'=>route('edit_blog', [$blog->id]), 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true]) !!}
@else
    {!! Form::open(['url'=>route('create_blog'), 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true]) !!}
@endif
{{ csrf_field() }}
<div class="row">
    {{ Form::label('title', 'Заголовок страницы') }}
    <div>
        {!! Form::text('title', old('title') ? : ($blog->title ?? '') , ['placeholder'=>'Title', 'id'=>'title', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
        {{ Form::label('img', 'Основное изображение') }}
        @if(!empty($blog->image))
            <img class="img-thumbnail" src="@if(File::exists(public_path('/images/blog/tmp/') . $blog->image)){{ asset('images/blog/tmp') . '/' . $blog->image }}@else{{ asset('images/blog/main') . '/' . $blog->image }}@endif">
        @endif
    <div>
        {!! Form::file('img', ['accept'=>'image/*', 'id'=>'img', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('cats', 'Категория') }}
    <div>
        {!! Form::select('cats', $cats ?? [],
            old('cats') ? : ($blog->category ?? '') , [ 'class'=>'form-control', 'placeholder'=>'Категория'])
        !!}
    </div>
</div>
<div class="row">
    <!-- Moderated -->
    <label><input type="checkbox" {{ old('moder') || (!empty($blog->moderate)) ? 'checked' : ''}} value="1" name="moder"> Отправить модератору</label>
</div>
<div class="row">
    <textarea name="content" class="form-control editor">{!! old('content') ? : ($blog->content ?? '') !!}</textarea>
    {!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
</div>
{!! Form::close() !!}
