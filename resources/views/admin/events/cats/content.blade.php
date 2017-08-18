<h1>Добавление \ Редактирование категорий</h1>

{!! Form::open(['url' => route('eventcats_admin'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('eventcat', 'Название категории') }}
    <div class="row">
    {!! Form::text('eventcat', old('eventcat') ? : '' , ['placeholder'=>'Психиатрия...', 'id'=>'eventcat', 'class'=>'form-control']) !!}
    </div>
    {{ Form::label('alias', 'Псевдоним') }}
    <div class="row">
        {!! Form::text('alias', old('alias') ? : '' , ['placeholder'=>'psihiatriya...', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.add_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>


@if(!empty($categories))
    <table class="table">
        <thead>
        <tr><th>ID</th><th>Имя</th><th>Псевдоним</th><th>Редактировать</th></tr>
        </thead>
        <tbody>
    @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->alias }}</td>
                <td>
                    {!! Form::open(['url' => route('eventcats_edit',['eventcat'=> $category->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($categories->lastPage() > 1)
            <ul class="pagination">
                @if($categories->currentPage() !== 1)
                    <li><a href="{{ $categories->url(($categories->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $categories->lastPage(); $i++)
                    @if($categories->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $categories->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($categories->currentPage() !== $categories->lastPage())
                    <li><a href="{{ $categories->url(($categories->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif