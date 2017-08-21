@extends('/../layouts/app')

@section('content')
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('docs') }}">Врачи</a></li>
                <li><a href="{{ route('clinics') }}">Клиники</a></li>
                <li><a href="{{ route('distributors') }}">Дистрибьюторы</a></li>
                <li><a href="{{ route('brands') }}">Бренды</a></li>
            </ul>
        </div>
    </nav>
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
    <div class="col-lg-2 col-lg-offset-1">
        {!! $sidebar !!}
    </div>
@endsection
