@extends('layouts.app')

@section('content')
@if (count($errors) > 0)
    <div class="contact-form">
        <p class="error">

                {{ dump($errors)  }}
        </p>
    </div>
@endif
@if (session('status'))
    <div  class="alert alert-success">
        <p class="success">{{ session('status') }}</p>
    </div>
@endif
<h2>Resend confirmation</h2>
<div class="col-md-6">
{!! Form::open([
    'route' => 'resend_activation',
    'class' => 'contact-form',
    'method' => 'POST',
    'enctype' => 'multipart/form-data',
    'novalidate'=>'',
]) !!}
{{ csrf_field() }}
<h4>{!! Form::label('email', 'Email') !!}</h4>
{!! Form::text('email', null,['class' => 'form-control']) !!}
<!-- Submit -->
{!! Form::button('Send', ['class' => 'btn-primary','type'=>'submit']) !!}
{!! Form::close() !!}
<h3>Or</h3>
<a href="{{route('login')}}">Login</a>
</div>
@endsection