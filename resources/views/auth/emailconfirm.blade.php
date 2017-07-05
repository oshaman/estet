@extends('layouts.app')
@section('content')
    <div class=”container”>
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
        <div class=”row”>
            <div class=”col-md-8 col-md-offset-2">
            <div class=”panel panel-default”>
                <div class=”panel-heading”>Registration Confirmed</div>
                <div class=”panel-body”>
                    Your Email is successfully verified. Click here to <a href="{{route('login')}}">login</a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection