<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_blog'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
    <h3>Поиск статьи блога:</h3>
    <div class="row">
        {{ Form::label('value', 'Параметр поиска') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        {!! Form::select('param',
            [
                1=>'Отправленные на модерацию',
                2=>'Псевдоним статьи',
                3=>'Заголовок',
                4=>'Все опубликованные',
            ], old('val') ? : 1, ['class'=>'custom-select'])
        !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    <hr>
    {!! Form::close() !!}
    <div class="row">
        {!! Html::link(route('create_blog'),'Создать статью блога',['class' => 'btn btn-success']) !!}
    </div>
</div>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th><th>Дата публикации</th>
        </tr>
        </thead>
        @if (!empty($blogs))
            <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->created_at }}</td>
                    <td>
                        <form method="GET" action="{{ route('edit_blog', (key_exists('blog_id',$blog->toArray()) ? $blog->id : ('0/' . $blog->id) ))}}"
                                    accept-charset="UTF-8" class="form-horizontal">
                            <button type="submit" class="btn btn-warning">{{ trans('admin.edit_btn') }}</button>
                        </form>
                    </td>
                    @if(key_exists('blog_id',$blog->toArray()))
                        <td>
                            {!! Form::open(['url' => route('destroy_tmp',['blog'=> $blog->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                            {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
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
    </table>
</div>
<!-- END CONTENT -->