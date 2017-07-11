@extends('/../layouts.app')
@section('content')
    <div class="container">
        <!-- Status -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <p class="error">
                    @foreach ($errors->toArray() as $key=>$error)
                    {!! str_replace($key, '<strong>' . trans('admin.' . $key) . '</strong>', $error[0]) !!}</br>
                    @endforeach
                </p>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    <!-- End status-->
        @if (!empty($profile))
        <div class="row">
            <div class="col-xs-6">
                <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/tmp_profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
            </div>
            <div class="col-xs-6">
                <div class="row">
                    <h3>{{ $profile->name ?? ''}}</h3>
                    <h3>{{ $profile->lastname ?? ''}}</h3>
                    <hr>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-lg-2"><h5>Врач: </h5></div>
                            <div class="col-lg-10"><h5>{{ $profile->specialty ?? ''}}</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><h5>Опыт: </h5></div>
                        <div class="col-lg-10"><h5>{{ $profile->expirience ?? ''}}</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><h5>Адрес: </h5></div>
                        <div class="col-lg-10"><h5>{{ $profile->address ?? ''}}</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><h5>Телефон: </h5></div>
                        <div class="col-lg-10"><h5>{{ $profile->phone ?? ''}}</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><h5>E-mail: </h5></div>
                        <div class="col-lg-10"><h5>{{ $profile->email ?? ''}}</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2"><h5>Сайт: </h5></div>
                        <div class="col-lg-10"><h5>{{ $profile->site ?? ''}}</h5></div>
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
                    {{ $profile->services ?? ''}}
                    <hr>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection