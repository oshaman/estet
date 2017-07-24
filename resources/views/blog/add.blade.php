<h2>{{$content}}</h2>
@if (empty($blogs->approved))
    <span class="label label-warning">Ваши данные не проверены модератором</span>
@endif
{!! Form::open(['url'=>route('create_blog'), 'method'=>'post']) !!}
<div class="row">
    {{ Form::label('title', 'Заголовок страницы') }}
    <div>
        {!! Form::text('title', old('title') ? : '' , ['placeholder'=>'Title', 'id'=>'title', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('main_img', 'Основное изображение') }}
    <div>
        {!! Form::file('main_img', ['accept'=>'image/*', 'id'=>'main_img', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('alias', 'Псевдоним страницы') }}
    <div>
        {!! Form::text('alias', old('alias') ? : '' , ['placeholder'=>'psevdonim-stranici', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('cats', 'Категории') }}
    <div>
        {!! Form::select('cats', $cats ?? [],
            old('cats') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Категория'])
        !!}
    </div>
</div>
<div class="row">
    {{ Form::label('tags', 'Тэги') }}
    @if(!empty($tags))
    <div>
        <table class="table">
            @foreach($tags as $id=>$tag)
                <td>
                    <input name="tags[]"  type="checkbox" value="{{ $id }}"> {{ $tag }}
                </td>
            @endforeach
        </table>
    </div>
    @endif
</div>
<!-- SEO -->
<div class="row">
    <h2>SEO</h2>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('seo_title', 'SEO_TITLE') }}
            <div>
                {!! Form::text('seo_title', old('seo_title') ? : '' , ['placeholder'=>'seo_title', 'id'=>'seo_title', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-lg-6">
            {{ Form::label('seo_keywords', 'SEO_KEYWORDS') }}
            <div>
                {!! Form::text('seo_keywords', old('seo_keywords') ? : '' , ['placeholder'=>'seo_keywords', 'id'=>'seo_keywords', 'class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('seo_description', 'SEO_DESCRIPTION') }}
            <div>
                {!! Form::text('seo_description', old('seo_description') ? : '' , ['placeholder'=>'seo_description', 'id'=>'seo_description', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-lg-6">
            {{ Form::label('og_image', 'OG_IMAGE') }}
            <div>
                {!! Form::text('og_image', old('og_image') ? : '' , ['placeholder'=>'og_image', 'id'=>'og_image', 'class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('og_title', 'OG_TITLE') }}
            <div>
                {!! Form::text('og_title', old('og_title') ? : '' , ['placeholder'=>'og_title', 'id'=>'og_title', 'class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-lg-6">
            {{ Form::label('og_description', 'OG_DESCRIPTION') }}
            <div>
                {!! Form::text('og_description', old('og_description') ? : '' , ['placeholder'=>'og_description', 'id'=>'og_description', 'class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        {{ Form::label('seo_text', 'SEO_TEXT') }}
        <div>
            <textarea name="seo_text" class="form-control">{!! old('seo_text') ? : '' !!}</textarea>
        </div>
    </div>
</div>
<!-- SEO -->
<div class="row">
    <label><input type="checkbox" {{ old('approved') ? 'checked' : ''}} value="approved" name="confirmed"> В тираж</label>
</div>
<div class="row">
    <textarea name="content" class="form-control editor">{!! old('content') ? : '' !!}</textarea>
    {!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
</div>
{!! Form::close() !!}
