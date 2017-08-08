@if($blogs)
    <ul>
        @foreach($blogs as $blog)
            <li>
                <a href="{{ route('blogs', $blog->alias) }}"><h3>{{ $blog->title }}</h3></a>
            </li>
        @endforeach
    </ul>
@endif