@extends('/../layouts.app')
@section('content')

    <h1>Edit profile</h1>
    {!! Form::open(['url' => route('edit_profile'), 'class'=>'form-horizontal', 'method'=>'POST', 'files'=>true]) !!}
    {{ csrf_field() }}
    <ul class="list-group">
        <li class="list-group-item">
            {{ Form::label('name', '* Имя') }}
            <div>
                {!! Form::text('name', old('name') ? : ($profile->name ?? '' ), ['placeholder'=>'Или имя отчество', 'id'=>'name',
                            'required' => '', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('lastname', '* Фамилия') }}
            <div>
                {!! Form::text('lastname', old('lastname') ? : ($profile->lastname ?? '' ), ['placeholder'=>'Фамилия', 'id'=>'lastname',
                            'required' => '', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('phone', '* Телефон') }}
            <div>
                {!! Form::text('phone', old('phone') ? : ($profile->phone ?? '' ), ['placeholder'=>'+380 ...', 'id'=>'phone',
                            'required' => '', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('specialty', '* Специальность') }}
            <div>
                {!! Form::text('specialty', old('specialty') ? : ($profile->specialty ?? '' ), ['placeholder'=>'Дерматолог, хирург...', 'id'=>'specialty',
                            'required' => '', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('category', 'Категория') }}
            <div>
                {!! Form::text('category', old('category') ? : ($profile->category ?? '' ), ['placeholder'=>'Врач высшей кат...', 'id'=>'category', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('job', 'Место основной работы') }}
            <div>
                {!! Form::text('job', old('job') ? : ($profile->job ?? '' ), ['placeholder'=>'Институт, клиника...', 'id'=>'job', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('address', 'Адрес основной работы') }}
            <div>
                {!! Form::text('address', old('address') ? : ($profile->address ?? '' ), ['placeholder'=>'Страна, город...', 'id'=>'address','class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('expirience', 'Опыт') }}
            <div>
                {!! Form::text('expirience', old('expirience') ? : ($profile->expirience ?? '' ), ['placeholder'=>'Кол-во полных лет практики', 'id'=>'expirience', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('shedule', 'Часы приема') }}
            <div>
                {!! Form::text('shedule', old('shedule') ? : ($profile->shedule ?? '' ), ['placeholder'=>'Пн-Ср 10:00-17:00', 'id'=>'shedule', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('services', 'Услуги') }}
            <div>
                {!! Form::text('services', old('services') ? : ($profile->services ?? '' ), ['placeholder'=>'Пересадка бровей, ресниц, бороды...', 'id'=>'services', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('site', 'Сайт') }}
            <div>
                {!! Form::text('site', old('site') ? : ($profile->site ?? '' ), ['placeholder'=>'Оставьте поле пустым, чтобы использовался профиль данного сайта', 'id'=>'site', 'class'=>'form-control']) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('content', 'О себе') }}
            <div>
                {!! Form::textarea('content', old('content') ? : ($profile->content ?? '' ), ['id'=>'content','rows'=>8, 'cols'=>100]) !!}
            </div>
        </li>
        <li class="list-group-item">
            {{ Form::label('img', 'Фото') }}
            <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/tmp_profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
            <div>
                {!! Form::file('img', ['accept'=>'image/*', 'id'=>'img']) !!}
            </div>
        </li>
    </ul>
    {!! Form::button(trans('admin.save'), ['class' => 'btn btn-success','type'=>'submit']) !!}
    {!! Form::close() !!}
@endsection