@extends('layouts.app')

@section('content')
<div class="container">
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

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Resend confirmation</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('resend_activation') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                    <a href="{{ route('login')  }}" class="btn btn-link">
                                        Login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection