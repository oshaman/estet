@extends('/../layouts/admin')

@section('navbar')
    @if ($nav)
        <div class="navbar-header">
            {!! Menu::get('adminMenu')->asUl(array('class' => 'nav nav-pills')) !!}
        </div>
    @endif
@endsection

@section('content')
    {!! $content !!}
@endsection