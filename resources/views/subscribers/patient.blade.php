@if(!empty($articles))
    @foreach($articles as $article)
        <div class="row">
            <h2>{{ $article->title }}</h2>
            <hr>
        </div>
    @endforeach
@endif