<div class="aside-block subscribe-block">
    <div class="form-wrap">
        {!! Form::open(['url'=>route('subscribe')]) !!}
        <h4 class="form-title">Будь в курсе последних новостей</h4>
        <strong>подпишись на рассылку</strong>
        <label>{!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Email', 'id'=>'email', 'class'=>'form-control']) !!}</label>
        <label>
            {!! Form::select('status', [0=>'Пациент', 1=>'Доктор'],
                old('status') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Доктор\Пациент'])
            !!}
        </label>
        <button class="pod-subs
            @if(session()->has('doc'))
                pod-purpur
            @endif
            " type="button">Подписаться</button>
        {!! Form::close() !!}
    </div>
</div>