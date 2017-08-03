@extends('/../layouts/app')

@section('navbar')
    @if ($nav)
        <div class="navbar-header">
            {!! Menu::get('docsMenu')->asUl(array('class' => 'nav nav-pills')) !!}
        </div>
    @endif
@endsection

@section('content')
    {!! $content !!}
@endsection