@extends('/../layouts/app')

@section('navbar')
    @if ($nav)
        <a class="navbar-brand" href="{{ route('events') }}"> Мероприятия</a>
        <a class="navbar-brand" href="{{ route('blogs') }}"> Блог</a>
        <ul class="nav navbar-nav">
            &nbsp;<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cтатьи<span class="caret"></span></a>
                {!! Menu::get('docsMenu')->asUl(array('class' => 'dropdown-menu')) !!}
            </li>
        </ul>

    @endif
@endsection

@section('content')
    {!! $content ?? '' !!}
@endsection