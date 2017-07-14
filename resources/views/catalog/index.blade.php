@extends('/../layouts.app')
@section('content')
<h1>{{ $title }}</h1>
@if (!empty($profiles))
@foreach($profiles as $profile)
     <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="row">
                    <h3>{{ ($profile->name ?? '') . ' ' . ($profile->lastname ?? '')}}</h3>
                    <hr>
                </div>
                <div class="row">
                    <h4>{{ $profile->specialties->implode('name', ', ') ?? ''}}</h4>
                    <hr>
                @if(!empty($profile->address))
                    <h4>{{ $profile->address}}</h4>
                @endif
                @if(!empty($profile->job))
                    <h4>{{ $profile->job ?? ''}}</h4>
                @endif
                    <h4>{{ $profile->phone ?? ''}}</h4>
                    <h4>{{ $profile->site ?? ''}}</h4>
                    <hr>
                </div>
            </div>
            <div class="col-xs-3">
                <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/tmp_profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
            </div>
        </div>
        <div class="row">
            {!! Form::open(['url' => route('docs', $profile->alias), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
            {!! Form::button('Подробнее о ' . trans('ru.doce'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endforeach
@endif
@endsection