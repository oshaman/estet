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
                    {!! Form::open(['url' => route('brands',['brand'=> $prem->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </p>
            </div>
        </div>
        <hr>
    @endforeach
@endif
@if(!empty($brands))
    @foreach($brands as $brand)
    <div class="row">
        <div class="col-lg-4">
            {{ Html::image(asset('/images/establishment/main') . '/' . $brand->logo, $brand->title, array('class' => 'img-thumbnail')) }}
        </div>
        <div class="col-lg-8">
            <h3>{{ $brand->title }}</h3>
            <p>{!! str_limit($brand->content, 254) !!}</p>
            <hr>
            <h6>{{ $brand->address }}</h6>
            <p>
                {!! Form::open(['url' => route('brands',['brand'=> $brand->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
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
    @if($brands->lastPage() > 1)
        <ul class="pagination">
            @if($brands->currentPage() !== 1)
                <li><a href="{{ $brands->url(($brands->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
            @endif

            @for($i = 1; $i <= $brands->lastPage(); $i++)
                @if($brands->currentPage() == $i)
                    <li><a class="active disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $brands->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($brands->currentPage() !== $brands->lastPage())
                <li><a href="{{ $brands->url(($brands->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
            @endif
        </ul>
    @endif
</div>