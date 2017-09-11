@if($blogs)
    <ul class="list-group">
    @foreach($blogs as $blog)
        <li class="list-group-item">
            <a href="{{ route('blogs', $blog->alias) }}"><h3>{{ $blog->title }}</h3></a>
        </li>
    @endforeach
    </ul>
@endif