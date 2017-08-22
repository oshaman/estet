<h2>Создание мероприятия</h2>
{!! Form::open(['url' => route('create_event'), 'class' => 'form-horizontal', 'files' => true, 'method' => 'post']) !!}
<div class="row">
    {{ Form::label('title', 'Заголовок страницы') }}
    <div>
        {!! Form::text('title', old('title') ? : '' , ['placeholder'=>'Title', 'id'=>'title', 'class'=>'form-control']) !!}
    </div>
</div>
<div class="row">
    {{ Form::label('alias', 'Псевдоним страницы') }}
    <div>
        {!! Form::text('alias', old('alias') ? : '' , ['placeholder'=>'psevdonim-meropriyatiya', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
</div>
{{--Организатор Категория--}}
<div class="row">
    <div class="col-lg-6">
        {{ Form::label('organizer', 'Организатор') }}
        <div>
            {!! Form::select('organizer', $organizers,
                old('organizer') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Организатор'])
            !!}
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('cats', 'Категория') }}
        <div>
            {!! Form::select('cats', $cats,
                old('cats') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Категория'])
            !!}
        </div>
    </div>
</div>
<hr>
{{--Cтрана Город--}}
<div class="row">
    <div class="col-lg-6">
        {{ Form::label('country', 'Страна') }}
        <div>
            {!! Form::select('country', $countries,
                old('country') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Страна'])
            !!}
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('city', 'Город') }}
        <div>
            <div>
                <select id="city" name="city" class="form-control">
                    <option value="" selected="selected">Город</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" data-country="{{ $city->country_id }}"
                                @if(old('city') == $city->id)
                                    selected="selected"
                                @endif
                        >{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
{{--Дата проведения--}}
<div class="row">
    <div class="col-lg-6">
        {{ Form::label('start', 'Дата начала') }}
        <div>
            <div>
                <input type="text" name="start" id="start" value="{{ old('start') ? : date('d-m-Y') }}">
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        {{ Form::label('stop', 'Дата окончания') }}
        <div>
            <input type="text" name="stop" id="stop" value="{{ old('stop') ? : date('d-m-Y') }}">
        </div>
    </div>
</div>
<hr>
{{-- Логотип --}}
<div class="row">
    {{ Form::label('img', 'Параметры логотипа') }}
    <div class="row">
        <div class="col-lg-6">
            {!! Form::text('imgalt', old('imgalt') ? : '' , ['placeholder'=>'Alt', 'id'=>'imgalt', 'class'=>'form-control']) !!}
        </div>
        <div class="col-lg-6">
            {!! Form::text('imgtitle', old('imgtitle') ? : '' , ['placeholder'=>'Title', 'id'=>'imgtitle', 'class'=>'form-control']) !!}
        </div>
    </div>
    {{ Form::label('img', 'Логотип') }}
    <div>
        {!! Form::file('img', ['accept'=>'image/*', 'id'=>'img', 'class'=>'form-control']) !!}
    </div>
</div>
<hr>
{{-- Слайдер --}}
{{ Form::label('slider', 'Фото для слайдера') }}
<div class="row">
    <div class="shablon" style="display:none">
        <div>
            {!! Form::file('slider[]', ['accept'=>'image/*', 'class'=>'form-control']) !!}
            <span class="remove-this"><button type="button" class="btn btn-danger">-</button></span>
        </div>
    </div>
    <div class="block-to-add">
        <div>
            {!! Form::file('slider[]', ['accept'=>'image/*', 'class'=>'form-control']) !!}
            <span class="remove-this"><button type="button" class="btn btn-danger">-</button></span>
        </div>
    </div>
    <div class="add-new"><button type="button" class="btn btn-primary">+</button></div>
</div>
{{-- Слайдер --}}
<hr>
{{--Описание--}}
<div class="row">
    {{ Form::label('description', 'Описание (~60 слов)') }}
    <div>
        <textarea name="description" class="form-control">{!! old('description') ? : '' !!}</textarea>
    </div>
</div>
{{--Описание--}}
<hr>
<!-- SEO -->
<div class="panel-heading">
    <h2>
        <a data-toggle="collapse" href="#service" class="btn btn-info btn-block">SEO</a>
    </h2>
</div>
<div id="service" class="panel-collapse collapse row">    <h2>SEO</h2>
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
<hr>
{{ Form::label('content', 'Основной текст') }}
<div class="row">
    <textarea name="content" class="form-control editor">{!! old('content') ? : '' !!}</textarea>
</div>
<hr>
<div class="row">
    <!-- Approved -->
    <label><input type="checkbox" {{ old('confirmed') ? 'checked' : ''}} value="1" name="confirmed"> В тираж</label>
</div>
<hr>
{!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
{!! Form::close() !!}