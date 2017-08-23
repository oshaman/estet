<h2>Добавление учреждения</h2>
<div class="row">
    {!! Form::open(['url' => route('create_establishments'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=>true]) !!}
    <div class="row">
        {{ Form::label('title', 'Название') }}
        {!! Form::text('title', old('title') ? : '', ['placeholder' => 'Название учреждения', 'id'=>'title', 'class'=>'form-control']) !!}
    </div>
    {{--Alias Phones--}}
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('alias', 'Псевдоним') }}
            {!! Form::text('alias', old('alias') ? : '', ['placeholder' => 'nazvanie-uchrezhdeniya', 'id'=>'alias', 'class'=>'form-control']) !!}
        </div>
        <div class="col-lg-6">
            {{ Form::label('phones', 'Телефоны') }}
            {!! Form::text('phones', old('phones') ? : '', ['placeholder' => '+38 050 555 55 55', 'id'=>'phones', 'class'=>'form-control']) !!}
        </div>
    </div>
    {{--Logo--}}
    {{ Form::label('logo', 'Логотип') }}
    <div class="row">
        {!! Form::file('logo', ['accept'=>'image/*', 'id'=>'logo', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('category', 'Категория') }}
            {!! Form::select('category', ['Клиника', 'Дистрибьютор', 'Бренд'],
                old('category') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Категория'])
            !!}
        </div>
        <div class="col-lg-6">
            {{ Form::label('parent', 'Родитель') }}
            {!! Form::select('parent', $parents,
                old('parent') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Родитель'])
            !!}
        </div>
    </div>
    <div class="row">
        {{ Form::label('address', 'Адрес') }}
        {!! Form::text('address', old('address') ? : '', ['placeholder' => 'Город, улица...', 'id'=>'address', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('site', 'Сайт') }}
            {!! Form::text('site', old('site') ? : '', ['placeholder' => 'http://site.com...', 'id'=>'site', 'class'=>'form-control']) !!}
        </div>
        <div class="col-lg-6">
            {{ Form::label('spec', 'Специализация') }}
            {!! Form::text('spec', old('spec') ? : '', ['placeholder' => 'специализация...', 'id'=>'spec', 'class'=>'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            {{ Form::label('services', 'Услуги\Категории продукции') }}
            <div class="block-to-add">
                <div>
                    {!! Form::text('services[]', old('services[0]') ? : '', ['placeholder' => 'список...', 'id'=>'services[]', 'class'=>'form-control']) !!}
                    <span class="remove-this"></span>
                </div>
            </div>
            <div class="add-new"><button type="button" class="btn btn-primary">+</button></div>
        </div>
        <div class="col-lg-6">
            <h5>Дополнительно</h5>
            <div class="col-lg-6">
                {!! Form::text('extra[0][0]', old('extra[0][0]') ? : '', ['placeholder' => 'Ключ 1', 'class'=>'form-control']) !!}
                {!! Form::text('extra[0][1]', old('extra[0][1]') ? : '', ['placeholder' => 'Значение 1', 'class'=>'form-control']) !!}
            </div>
            <div class="col-lg-6">
                {!! Form::text('extra[1][0]', old('extra[1][0]') ? : '', ['placeholder' => 'Ключ 2', 'class'=>'form-control']) !!}
                {!! Form::text('extra[1][1]', old('extra[1][1]') ? : '', ['placeholder' => 'Значение 2', 'class'=>'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        {{ Form::label('content', 'Описание') }}
        <textarea name="content" class="form-control editor">{!! old('content') ? : '' !!}</textarea>
    </div>
    <hr>
    {!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
<div class="shablon" style="display:none">
    <div>
        {!! Form::text('services[]', old('services[0]') ? : '', ['placeholder' => 'список...', 'id'=>'services[]', 'class'=>'form-control']) !!}
        <span class="remove-this"><button type="button" class="btn btn-danger">-</button></span>
    </div>
</div>