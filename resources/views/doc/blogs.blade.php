@if(!empty($blogs))
    @foreach($blogs as $blog)
        <div class="row">
            <div class="col-lg-6">
                {{dump($blog->blog_img)}}}
            </div>
            <div class="col-lg-6"></div>
        </div>
    @endforeach
@endif