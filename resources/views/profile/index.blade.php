@extends('/../layouts.app')
@section('content')
    @if (empty($profile->approved))
        <span class="label label-warning">Ваши данные не проверены модератором</span>
    @endif
    <div class="row">
        <div class="col-xs-6">
            @if (!empty($profile->photo) && File::exists(public_path(config('settings.theme')). '/img/tmp_profile/main/' . $profile->photo ))
                <img class="img-thumbnail"
                     src="{{ asset(config('settings.theme'))  . '/img/tmp_profile/main/' . ($profile->photo ?? '../no_photo.jpg') }}">
            @else
                <img class="img-thumbnail"
                     src="{{ asset(config('settings.theme'))  . '/img/profile/main/' . ($profile->photo ?? '../no_photo.jpg') }}">
            @endif
        </div>
        <div class="col-xs-6">
            <div class="row">
                <h3>{{ $profile->name ?? '' }}</h3>
                <h3>{{ $profile->lastname ?? '' }}</h3>
                <hr>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-lg-2"><h5>Врач: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->specialty ?? '' }}</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><h5>Опыт: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->expirience ?? '' }}</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><h5>Адрес: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->address ?? '' }}</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><h5>Телефон: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->phone ?? '' }}</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><h5>E-mail: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->email ?? '' }}</h5></div>
                </div>
                <div class="row">
                    <div class="col-lg-2"><h5>Сайт: </h5></div>
                    <div class="col-lg-10"><h5>{{ $profile->site ?? '' }}</h5></div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8">
            <h3>О враче</h3>
            {{ $profile->content ?? ''}}
        </div>
        <div class="col-xs-4">
            <div class="row">
                <h3>Место работы:</h3>
                {{ $profile->job ?? ''}}
                <hr>
            </div>
            <div class="row">
                <h3>Расписание:</h3>
                {{ $profile->shedule ?? ''}}
                <hr>
            </div>
            <div class="row">
                <h3>Категория:</h3>
                {{ $profile->category ?? ''}}
                <hr>
            </div>
            <div class="row">
                <h3>Услуги:</h3>
                @if(!empty($profile->services) && is_array($profile->services))
                    <ul>
                    @foreach($profile->services as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                    </ul>
                @endif
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        {!! Form::open(['url' => route('edit_profile'), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>
@endsection