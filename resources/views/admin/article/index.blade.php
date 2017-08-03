<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('articles'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
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
                        4=>'В разделе врачей',
                        5=>'В разделе пациентов',
                    ], old('val') ? : 1, ['class'=>'custom-select'])
            !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="row">
    {!! Html::link(route('create_article'),'Создать статью',['class' => 'btn btn-success']) !!}
</div>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Ссылка</th><th>Заголовок</th><th>Дата публикации</th>
        </tr>
        </thead>
        @if (!empty($articles[0]))
            <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $article->alias }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->created_at }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_article',['article'=> $article->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    <td>
                        {!! Form::open(['url' => route('delete_article',['article'=> $article->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <!--PAGINATION-->

            <div class="general-pagination group">

                @if(is_object($articles) && !empty($articles->lastPage()) && $articles->lastPage() > 1)
                    <ul class="pagination">
                        @if($articles->currentPage() !== 1)
                            <li><a href="{{ $articles->url(($articles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                        @endif

                        @for($i = 1; $i <= $articles->lastPage(); $i++)
                            @if($articles->currentPage() == $i)
                                <li><a class="selected disabled">{{ $i }}</a></li>
                            @else
                                <li><a href="{{ $articles->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if($articles->currentPage() !== $articles->lastPage())
                            <li><a href="{{ $articles->url(($articles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                        @endif
                    </ul>

                @endif

            </div>
        @endif
    </table>
</div>
<!-- END CONTENT -->