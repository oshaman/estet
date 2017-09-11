<h1>Добавление \ Редактирование организаторов</h1>

{!! Form::open(['url' => route('organizers_admin'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('organizer', 'Организатор') }}
    <div class="row">
        {!! Form::text('organizer', old('eventcat') ? : '' , ['placeholder'=>'название...', 'id'=>'organizer', 'class'=>'form-control']) !!}
    </div>
    {{ Form::label('alias', 'Псевдоним') }}
    <div class="row">
        {!! Form::text('alias', old('alias') ? : '' , ['placeholder'=>'nazvanie...', 'id'=>'alias', 'class'=>'form-control']) !!}
    </div>
    {{ Form::label('parent', 'ID родителя') }}
    <div class="row">
        {!! Form::text('parent', old('parent') ? : '' , ['placeholder'=>'ID', 'id'=>'parent', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.add_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>


@if(!empty($organizers))
    <table class="table">
        <thead>
        <tr><th>ID</th><th>Имя</th><th>Псевдоним</th><th>Родитель</th><th>Редактировать</th></tr>
        </thead>
        <tbody>
    @foreach($organizers as $organizer)
            <tr>
                <td>{{ $organizer->id }}</td>
                <td>{{ $organizer->name }}</td>
                <td>{{ $organizer->alias }}</td>
                <td>{{ $organizer->parent ?? '' }}</td>
                <td>
                    {!! Form::open(['url' => route('organizer_edit',['organizer'=> $organizer->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($organizers->lastPage() > 1)
            <ul class="pagination">
                @if($organizers->currentPage() !== 1)
                    <li><a href="{{ $organizers->url(($organizers->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $organizers->lastPage(); $i++)
                    @if($organizers->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $organizers->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($organizers->currentPage() !== $organizers->lastPage())
                    <li><a href="{{ $organizers->url(($organizers->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif