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
                            <h4>{{ $profile->specialty ?? ''}}</h4>
                            <hr>
                            <h4>{{ $profile->address ?? ''}}</h4>
                            <h4>{{ $profile->job ?? ''}}</h4>
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
    </div>
@endsection