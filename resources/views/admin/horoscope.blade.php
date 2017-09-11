{{--{{dd($signs)}}--}}
@if(!empty($signs))
    {!! Form::open(['url'=>route('admin_goroscop'), 'method'=>'POST', 'class'=>'form-horizontal']) !!}
    @foreach($signs as $key=>$sign)
        <div class="row">
            {{ Form::label($key, trans('admin.'.$key)) }}
            <div>
                <textarea name="{{ $key }}" class="form-control" rows="10">{!! old($key) ? : ($sign ?? '') !!}</textarea>
            </div>
        </div>
    @endforeach
    {!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
    {!! Form::close() !!}
@endif