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
    @if (empty($profile->approved))
        <span class="label label-warning">Ваши данные не проверены модератором</span>
    @endif
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
                <h4><span>Врач: </span>{{ $profile->specialty ?? ''}}</h4>
                <h4>Опыт: {{ $profile->expirience ?? ''}}</h4>
                <h4>Адрес: {{ $profile->address ?? ''}}</h4>
                <h4>Телефон: {{ $profile->phone ?? ''}}</h4>
                <h4>E-mail: {{ $profile->email ?? ''}}</h4>
                <h4>Сайт: {{ $profile->site ?? ''}}</h4>
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
    <div class="row">
        {!! Form::open(['url' => route('edit_profile'), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection