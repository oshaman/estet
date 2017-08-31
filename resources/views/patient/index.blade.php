@extends('/../layouts/app')

@section('navbar')
    {!! $nav !!}
@endsection

@section('content')
    @if(!empty($sidebar))
        <div class="col-lg-9">
            {!! $content ?? '' !!}
        </div>
        <div class="col-lg-2 col-lg-offset-1">
            {!! $sidebar !!}
        </div>
    @else
        {!! $content ?? '' !!}
    @endif
@endsection