@if($articles)
    <ul>
        @foreach($articles as $article)
            <li>
                <a href="{{ route('doctors', $article->alias) }}"><h3>{{ $article->title }}</h3></a>
            </li>
        @endforeach
    </ul>
@endif