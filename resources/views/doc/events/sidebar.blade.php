<div class="row">
    <h3>Последние мероприятия</h3>
    @if($lasts)
        @foreach($lasts as $last)
            <div class="row">
                <p><span class="label label-default">{{ $last->created }}</span></p>
                <p><a href="{{ route('events', $last->alias) }}"> {{ $last->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>
<hr>
<div class="row">
    <h3>Самое популярное</h3>
    @if($articles)
        @foreach($articles as $article)
            <div class="row">
                <p><span class="label label-default">{{ $article->created }}</span></p>
                <p><a href="{{ route('doctors', $article->alias) }}"> {{ $article->title }}</a></p>
            </div>
        @endforeach
    @endif
</div>