@if(!empty($blogs))
    @foreach($blogs as $blog)
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('/images/blog/middle') . '/' . $blog->blog_img->path }}"
                     alt="{{ $blog->blog_img->alt }}" title="{{ $blog->blog_img->title }}" class="img-thumbnail">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <span>{{ $blog->category->name }}</span> <span class="label label-default">{{ $blog->created }}</span>
                </div>
                <h2>{{ $blog->title }}</h2>
                <h5>{{ $blog->person->person->name . ' ' . $blog->person->person->lastname }}</h5>
                <p>
                    {!! Form::open(['url' => route('blogs',['blog'=> $blog->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </p>
            </div>
        </div>
    @endforeach
    <!--PAGINATION-->
    <div class="general-pagination group">
        @if($blogs->lastPage() > 1)
            <ul class="pagination">
                @if($blogs->currentPage() !== 1)
                    <li><a href="{{ $blogs->url(($blogs->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $blogs->lastPage(); $i++)
                    @if($blogs->currentPage() == $i)
                        <li><a class="active disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $blogs->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($blogs->currentPage() !== $blogs->lastPage())
                    <li><a href="{{ $blogs->url(($blogs->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>
        @endif
    </div>
@endif