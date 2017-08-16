<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_comments'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
    <h3>Поиск статьи блога:</h3>
    <div class="row">
        {{ Form::label('comment', 'ID коментария') }}
        {!! Form::text('comment', old('comment') ? : '' , ['placeholder'=>'ID', 'id'=>'comment', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        {!! Form::select('param',
                    [
                        1=>'Коментарии в статьях',
                        2=>'Коментарии в блоге',
                        3 =>'Коментарии в учреждениях',
                    ], old('val') ? : 1, ['class'=>'form-control'])
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
            <th>Имя автора</th><th>E-mail автора</th><th>Текст коментария</th>
        </tr>
        </thead>
        @if (!empty($comments[0]))
            <tbody>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->name }}</td>
                    <td>{{ $comment->email }}</td>
                    <td>{{ $comment->text }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_comment',['comment'=> $comment->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {{ Form::hidden('comment_source', $source) }}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    <td>
                        {!! Form::open(['url' => route('delete_comment',['comment'=> $comment->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {{ Form::hidden('comment_source', $source) }}
                        {!! Form::button(trans('admin.delete', ['comment'=> $comment->id]), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <!--PAGINATION-->

            <div class="general-pagination group">

                @if(is_object($comments) && !empty($comments->lastPage()) && $comments->lastPage() > 1)
                    <ul class="pagination">
                        @if($comments->currentPage() !== 1)
                            <li><a href="{{ $comments->url(($comments->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                        @endif

                        @for($i = 1; $i <= $comments->lastPage(); $i++)
                            @if($comments->currentPage() == $i)
                                <li><a class="selected disabled">{{ $i }}</a></li>
                            @else
                                <li><a href="{{ $comments->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if($comments->currentPage() !== $comments->lastPage())
                            <li><a href="{{ $comments->url(($comments->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                        @endif
                    </ul>

                @endif

            </div>
        @endif
    </table>
</div>
<!-- END CONTENT -->