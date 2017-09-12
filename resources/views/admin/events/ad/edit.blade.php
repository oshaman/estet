<h2>Редактирование Рекламы</h2>
<hr>
{!! Form::open(['url'=>route('update_events_slider', $advertising->id), 'method'=>'post', 'class'=>'form-horizontal', 'files' => true]) !!}
<div class="row">
    <div class="row">
        {{ Form::label('title', 'Заголовок') }}
        <div>
            {!! Form::text('title', old('title') ? : ($advertising->title ?? '') , ['placeholder'=>'text', 'id'=>'text', 'class'=>'form-control']) !!}
        </div>
    </div>
    <div class="row">
        {{ Form::label('extlink', 'Ссылка') }}
        <div>
            {!! Form::text('extlink', old('extlink') ? : ($advertising->extlink ?? '') , ['placeholder'=>'text', 'id'=>'text', 'class'=>'form-control']) !!}
        </div>
    </div>
    {{-- Логотип --}}
    <div class="row">
        @if(!empty($advertising->image))
            <div>
                {{ Html::image(asset('images/event/ad/main') . '/' . $advertising->image, 'a picture', array('class' => 'img-thumbnail')) }}
            </div>
        @endif
        {{ Form::label('img', 'Картинка') }}
        <div>
            {!! Form::file('img', ['accept'=>'image/*', 'id'=>'img', 'class'=>'form-control']) !!}
        </div>
    </div>
</div>
<hr>
{!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
{!! Form::close() !!}