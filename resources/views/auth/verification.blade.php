@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
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

                <div class="panel-heading">Регистрация</div>
                <div class="panel-body">
                    Ваш аккаунт успешно зарегистрирован. На указанный постовый ящик отправленно письмо для
                    подтверждения.
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection