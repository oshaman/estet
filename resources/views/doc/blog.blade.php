@if($blog)
    <div class="row">
        <div class="col-lg-3">
            {{ Html::image(asset('/estet/img/profile') . '/' . $blog->person->person->photo, 'alt', ['width' => 125]) }}
            <p>{{ $blog->person->person->lastname }}</p>
            <p>{{ $blog->person->person->name }}</p>
            <p>{{ $blog->person->person->specialties->implode('name', ', ') ?? '' }}</p>
            <p>{{ $blog->person->person->category }}</p>
        </div>
        <div class="col-lg-9">
            {{ Html::image(asset('/images/blog/main') . '/' . $blog->blog_img->path, $blog->blog_img->alt, ['title' => $blog->blog_img->title]) }}
        </div>
    </div>
    <div class="row">
        <span class="label label-default">{{ $blog->created }}</span>
        <h1>{{ $blog->title }}</h1>
    </div>
    <div class="row">
    @foreach($blog->tags as $tag)
            <span class="label label-info">{{ $tag->name }}</span>
    @endforeach
    </div>
    <div class="row"><h1>{!! $blog->content !!}</h1></div>
@endif