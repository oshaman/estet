@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                <div class="panel panel-default">
                    @if( Auth::check() &&  Auth::user()->verified !== 1)
                        <div class="panel-heading ">
                            <div class="alert alert-warning">
                                {{ trans('auth.confirm_activation') }}
                            </div>
                            <a href="{{ route('resend_activation')  }}" class="btn btn-link">
                                {{ trans('auth.resend_activation') }}
                            </a>
                        </div>
                    @endif
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection