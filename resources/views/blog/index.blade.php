<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_blog'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    <h3>Поиск блога:</h3>
    <div class="row">
        {{ Form::label('value', 'Ссылка') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'allergicheskiy-stomatit', 'id'=>'value', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="row">
    {!! Html::link(route('create_blog'),'Создать новый блог',['class' => 'btn btn-success']) !!}
</div>
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
                    <td>{{ $blog->date }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_blog',['blog'=> $blog->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
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