@extends('/../layouts.app')
@section('content')
<div class="container">
    {!! Form::open(['url' => route('edit_profile'), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-success','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
@endsection