<div class="col-lg-9">
{{--{{dd($signs)}}--}}
@if(!empty($signs))
    @foreach($signs as $key=>$sign)
        <div class="row">
            <h3>{{ trans('admin.' . $key) }}</h3>
            <div>{{ $sign }}</div>
        </div>
    @endforeach
@endif
</div>
<div class="col-lg-2 col-lg-offset-1">
    @if(!empty($sidebar))
        {!! $sidebar !!}
    @endif
</div>