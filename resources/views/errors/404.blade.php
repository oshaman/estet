@extends('/../layouts/app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if (isset($errors) && count($errors) > 0)
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

                    <img src="{{ asset('estet') . '/img/404.png' }}" class=".img-thumbnail">

                    <a class="btn btn-link" href="{{ route('main') }}">
                        GO Main
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection