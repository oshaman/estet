<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('view_blogs'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
    <h3>Поиск статьи блога:</h3>
    <div class="row">
        {{ Form::label('value', 'Параметр поиска') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        {!! Form::select('param',
                    [
                        1=>'Псевдоним статьи',
                        2=>'Заголовок',
                        3 =>'На паузе',
                        4=>'Все',
                        5=>'ID автора',
                    ], old('val') ? : 1, ['class'=>'custom-select'])
            !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Ссылка</th><th>Заголовок</th><th>Дата публикации</th>
        </tr>
        </thead>
        @if (!empty($blogs[0]))
            <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>{{ $blog->alias }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->created_at }}</td>
                    <td>
                        @if(key_exists('blog_id',$blog->toArray()))
                            @if($blog->blog_id)
                                {!! Form::open(['url' => route('moderate_blog',['blog'=> $blog->blog_id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                            @else
                                {!! Form::open(['url' => route('add_blog', $blog->id),'class'=>'form-horizontal','method'=>'GET']) !!}
                            @endif
                        @else
                            {!! Form::open(['url' => route('moderate_blog',['blog'=> $blog->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        @endif
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    @if(!key_exists('blog_id',$blog->toArray()))
                    <td>
                        {!! Form::open(['url' => route('destroy_blog',['blog'=> $blog->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            <!--PAGINATION-->

            <div class="general-pagination group">

                @if(is_object($blogs) && !empty($blogs->lastPage()) && $blogs->lastPage() > 1)
                    <ul class="pagination">
                        @if($blogs->currentPage() !== 1)
                            <li><a href="{{ $blogs->url(($blogs->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                        @endif

                        @for($i = 1; $i <= $blogs->lastPage(); $i++)
                            @if($blogs->currentPage() == $i)
                                <li><a class="selected disabled">{{ $i }}</a></li>
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
    </table>
</div>
<!-- END CONTENT -->