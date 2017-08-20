@extends('/../layouts/app')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    {!! $content ?? '' !!}
@endsection