@extends('/../layouts/app')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
    <div class="col-lg-2 col-lg-offset-1">
        {!! $sidebar !!}
    </div>
@endsection
