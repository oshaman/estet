<div class="form-wrap form-wrap-aside-block">
    {{--@if (count($errors) > 0)
        <div class="alert alert-danger">
            <p class="error">
                @foreach ($errors->toArray() as $key=>$error)
                {!! str_replace($key, '<strong>' . trans('admin.' . $key) . '</strong>', $error[0]) !!}</br>
                @endforeach
            </p>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif--}}
    {!! Form::open(['url'=>route('subscribe')]) !!}
    <h4 class="form-title">Будь в курсе последних новостей</h4>
    <strong>подпишись на рассылку</strong>
    <label>{!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Почта', 'id'=>'email', 'class'=>'form-control']) !!}</label>
    <label>
        {!! Form::select('status', [0=>'Пациент', 1=>'Доктор'],
            old('status') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Доктор\Пациент'])
        !!}
    </label>
    <button class="pod-subs
        @if(session()->has('doc'))
            pod-purpur
        @endif
            " type="submit">Подписаться
    </button>
    {!! Form::close() !!}
</div>