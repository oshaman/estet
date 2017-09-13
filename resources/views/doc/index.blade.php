@extends('/../layouts/main')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    {!! $content ?? '' !!}
@endsection


@section('footer')
    {!! $footer !!}
@endsection