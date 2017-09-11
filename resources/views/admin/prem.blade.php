<div class="container">
    {!! Form::open(['url' => route('premium'), 'class' => 'form-horizontal', 'method' => 'post']) !!}
    {!! Form::select('params',
                                        [
                                            'clinic'=>'Клиники',
                                            'distributor'=>'Дистрибьюторы',
                                            'brand'=>'Бренды',
                                            'event'=>'Мероприятия',
                                        ], null, ['placeholder' => 'Выбрать категорию', 'class' => 'form-control'])
                        !!}
        <!-- Submit -->
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
</div>
<h4>Добавить</h4>
@if(!empty($data))
    <hr>
    <div class="row">
        {!! Form::open(['url' => route('premium'), 'class' => 'form-horizontal', 'method' => 'post']) !!}
        {{ Form::hidden('category', $data[0]->category) }}
        <div class="row">
            <div class="col-lg-6">
                {{ Form::label('prem1', 'ID №1') }}<br>
                {!! Form::number('prem1', old('prem1') ?? ($data[0]->prem_id ?? '') ) !!}
            </div>
            <div class="col-lg-6">
                {{ Form::label('prem2', 'ID №2') }}<br>
                {!! Form::number('prem2', old('prem2') ?? ($data[1]->prem_id ?? '') ) !!}
            </div>
        </div>
        <hr>
        {!! Form::button(trans('admin.save'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
    </div>
@endif