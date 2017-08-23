@if(!empty($prems))
    @foreach($prems as $prem)
        <div class="row bg-info">
            <div class="col-lg-4">
                {{ Html::image(asset('/images/establishment/main') . '/' . $prem->logo, $prem->title, array('class' => 'img-thumbnail')) }}
            </div>
            <div class="col-lg-8">
                <h3>{{ $prem->title }}</h3>
                <p>{!! str_limit($prem->content, 254) !!}</p>
                <hr>
                <h6>{{ $prem->address }}</h6>
                <p>
                    {!! Form::open(['url' => route('distributors',['distributor'=> $prem->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </p>
            </div>
        </div>
        <hr>
    @endforeach
@endif
@if(!empty($distributors))
    @foreach($distributors as $distributor)
    <div class="row">
        <div class="col-lg-4">
            {{ Html::image(asset('/images/establishment/main') . '/' . $distributor->logo, $distributor->title, array('class' => 'img-thumbnail')) }}
        </div>
        <div class="col-lg-8">
            <h3>{{ $distributor->title }}</h3>
            <p>{!! str_limit($distributor->content, 254) !!}</p>
            <hr>
            <h6>{{ $distributor->address }}</h6>
            <p>
                {!! Form::open(['url' => route('distributors',['distributor'=> $distributor->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                {!! Form::close() !!}
            </p>
        </div>
    </div>
    <hr>
    @endforeach
@endif
<!--PAGINATION-->
<div class="general-pagination group">
    @if($distributors->lastPage() > 1)
        <ul class="pagination">
            @if($distributors->currentPage() !== 1)
                <li><a href="{{ $distributors->url(($distributors->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
            @endif

            @for($i = 1; $i <= $distributors->lastPage(); $i++)
                @if($distributors->currentPage() == $i)
                    <li><a class="active disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $distributors->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($distributors->currentPage() !== $distributors->lastPage())
                <li><a href="{{ $distributors->url(($distributors->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
            @endif
        </ul>
    @endif
</div>