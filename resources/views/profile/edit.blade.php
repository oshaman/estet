@extends('/../layouts.app')
@section('content')
<div class="container">
    <h1>Edit profile</h1>
    {!! Form::open(['url' => route('edit_profile'), 'class'=>'form-horizontal', 'method'=>'POST']) !!}
    {{ csrf_field() }}
    {!! Form::button(trans('admin.save'), ['class' => 'btn btn-success','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
@endsection