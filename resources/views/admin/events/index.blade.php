@extends('admin.index')

@section('content')
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('eventcats_admin') }}">Категории</a></li>
                <li><a href="{{ route('organizers_admin') }}">Организаторы</a></li>
                <li><a href="{{ route('create_event') }}">Создание мероприятия</a></li>
            </ul>
        </div>
    </nav>
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
@endsection