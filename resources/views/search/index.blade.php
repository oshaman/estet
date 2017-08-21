@extends('/../layouts/app')

@section('content')
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
    <div class="col-lg-2 col-lg-offset-1">
        {!! $sidebar !!}
    </div>
@endsection
