@if($articles)
    <ul>
        @foreach($articles as $artile)
            <li>
                <a href="{{ route('articles', $artile->alias) }}"><h3>{{ $artile->title }}</h3></a>
            </li>
        @endforeach
    </ul>
@endif