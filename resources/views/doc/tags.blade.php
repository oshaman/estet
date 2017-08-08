@if($articles)
    <ul class="list-group">
    @foreach($articles as $artile)
        <li class="list-group-item">
            <a href="{{ route('doctors', $artile->alias) }}"><h3>{{ $artile->title }}</h3></a>
        </li>
    @endforeach
    </ul>
@endif