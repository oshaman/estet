<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_blog'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    <h3>Поиск статьи блога:</h3>
    <div class="row">
        {{ Form::label('value', 'Параметр поиска') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        @if(Auth::user()->hasRole('moderator') || Auth::user()->hasRole('admin'))
            {!! Form::select('param',
                    [
                        1=>'Псевдоним статьи',
                        2=>'Заголовок',
                        3=>'Все',
                        4=>'ID автора',
                    ], old('val') ? : 1, ['class'=>'custom-select'])
            !!}
        @else
            {!! Form::select('param',
                    [
                        1=>'Псевдоним статьи',
                        2=>'Заголовок',
                        3=>'Все',
                    ], old('val') ? : 1, ['class'=>'custom-select'])
            !!}
        @endif
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
@if(!Auth::user()->canDo('CONFIRMATION_DATA'))
<div class="row">
    {!! Html::link(route('create_blog'),'Создать статью блога',['class' => 'btn btn-success']) !!}
</div>
@endif
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Ссылка</th><th>Заголовок</th><th>Дата публикации</th>
        </tr>
        </thead>
        @if (!empty($blogs))
            <tbody>
            @foreach ($blogs as $blog)
                <tr>
                    <td>{{ $blog->alias }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->created_at }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_blog',['blog'=> $blog->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    @if(Auth::user()->canDo('CONFIRMATION_DATA'))
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

                @if($blogs->lastPage() > 1)
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