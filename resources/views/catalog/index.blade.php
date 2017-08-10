@extends('/../layouts/app')

@section('content')
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
    <div class="col-lg-3">
        {!! $sidebar !!}
    </div>
@endsection
