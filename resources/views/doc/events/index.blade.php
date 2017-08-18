<div class="container">
    <div class="col-lg-9">
        <div class="row w-100 bg-info">
            {!! Form::open(['url'=>route('events'), 'method'=>'get', 'class'=>'form-horizontal']) !!}
            <div class="text-center">Выберите организатора</div>
            <div class="row">
                <div class="col-lg-4">
                    {{ Form::label('country', 'Выбрать страну') }}
                    {!! Form::select('country', $countries, old('country') ? : '', ['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-4">
                    {{ Form::label('city', 'Выбрать город') }}
                    {!! Form::select('city', $cities, old('city') ? : '', ['class'=>'form-control']) !!}
                </div>
                <div class="col-lg-4">
                    {{ Form::label('cat', 'Выбрать категорию') }}
                    {!! Form::select('cat', $cats, old('cat') ? : '', ['class'=>'form-control']) !!}
                </div>
                <hr>
            </div>
            <hr>
            <div>
                {{ Form::label('organizer', 'Выбрать организатора') }}
                {!! Form::select('organizer', $organizer, old('organizer') ? : '', ['class'=>'form-control']) !!}
            </div>
            <hr>
            {!! Form::close() !!}
        </div>
        {{--Premuim--}}
        <div class="row">
        @if(!empty($prems))
            @foreach($prems as $prem)
                    <div class="row bg-warning">
                        <div class="col-lg-4">
                            {{ Html::image(asset('/images/event/main') . '/' . $prem->logo->path, $prem->title, array('class' => 'img-thumbnail')) }}
                        </div>
                        <div class="col-lg-8">
                            <h3>{{ $prem->title }}</h3>
                            <p>{!! str_limit($prem->description, 254) !!}</p>
                            <hr>
                            <p>
                                {!! Form::open(['url' => route('events',['event_alias'=> $prem->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                                {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                                {!! Form::close() !!}
                            </p>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
        {{--Premuim--}}
        <div class="row">
        @if(!empty($events))
            @foreach($events as $event)
                    <div class="row">
                        <div class="col-lg-4">
                            {{ Html::image(asset('/images/event/main') . '/' . $event->logo->path, $event->title, array('class' => 'img-thumbnail')) }}
                        </div>
                        <div class="col-lg-8">
                            <h3>{{ $event->title }}</h3>
                            <p>{!! str_limit($event->description, 254) !!}</p>
                            <hr>
                            <p>
                                {!! Form::open(['url' => route('events',['event_alias'=> $event->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                                {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                                {!! Form::close() !!}
                            </p>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>

    <div class="col-lg-2 col-lg-offset-1">
        <div class="">

            {!! $sidebar !!}
        </div>
    </div>
</div>
<!--PAGINATION-->
<div class="general-pagination group">
    @if($events->lastPage() > 1)
        <ul class="pagination">
            @if($events->currentPage() !== 1)
                <li><a href="{{ $events->url(($events->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
            @endif

            @for($i = 1; $i <= $events->lastPage(); $i++)
                @if($events->currentPage() == $i)
                    <li><a class="active disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $events->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($events->currentPage() !== $events->lastPage())
                <li><a href="{{ $events->url(($events->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
            @endif
        </ul>
    @endif
</div>
