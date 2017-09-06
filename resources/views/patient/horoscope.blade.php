@if(!empty($signs))
    @foreach($signs as $key=>$sign)
        <div class="row" id="{{ $key }}">
            <h3>{{ trans('admin.' . $key) }}</h3>
            <div>{{ $sign }}</div>
        </div>
    @endforeach
@endif