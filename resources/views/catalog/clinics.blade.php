@if(!empty($clinics))
    @foreach($clinics as $clinic)
    <div class="row">
        <div class="col-lg-4">
            {{ Html::image(asset('/images/establishment/main') . '/' . $clinic->logo, $clinic->title, array('class' => 'img-thumbnail')) }}
        </div>
        <div class="col-lg-8">
            <h3>{{ $clinic->title }}</h3>
            <p>{!! str_limit($clinic->about, 254) !!}</p>
            <hr>
            <h6>{{ $clinic->address }}</h6>
            <p>
                {!! Form::open(['url' => route('clinics',['clinic'=> $clinic->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
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
    @if($clinics->lastPage() > 1)
        <ul class="pagination">
            @if($clinics->currentPage() !== 1)
                <li><a href="{{ $clinics->url(($clinics->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
            @endif

            @for($i = 1; $i <= $clinics->lastPage(); $i++)
                @if($clinics->currentPage() == $i)
                    <li><a class="active disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $clinics->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($clinics->currentPage() !== $clinics->lastPage())
                <li><a href="{{ $clinics->url(($clinics->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
            @endif
        </ul>
    @endif
</div>