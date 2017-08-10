<div class="row">
    <h3>Последние статьи</h3>
    @if(!empty($lasts))
        @foreach($lasts as $last)
            <div class="row">
                <p><span class="label label-default">{{ $last->created }}</span></p>
                @if($status)
                    <p><a href="{{ route('doctors', $last->alias) }}"> {{ $last->title }}</a></p>
                @else
                    <p><a href="{{ route('articles', $last->alias) }}"> {{ $last->title }}</a></p>
                @endif
            </div>
        @endforeach
    @endif
</div>
<hr>
<div class="row">
    <h3>Самое популярное</h3>
</div>