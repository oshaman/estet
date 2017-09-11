<h1>Добавление \ Редактирование специальностей</h1>

{!! Form::open(['url' => route('specialties'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
<div class="row">
    {{ Form::label('spec', 'Название специальности') }}
    <div class="row">
    {!! Form::text('spec', old('spec') ? : '' , ['placeholder'=>'Психиатр...', 'id'=>'spec', 'class'=>'form-control']) !!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.add_spec'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>


@if(!empty($specialties))
    <table class="table">
        <thead>
            <tr><th>Имя</th><th>Редактировать</th></tr>
        </thead>
        <tbody>
    @foreach($specialties as $specialty)
            <tr>
                <td>{{ $specialty->name }}</td>
                <td>
                    {!! Form::open(['url' => route('edit_specialties',['spec'=> $specialty->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($specialties->lastPage() > 1)
            <ul class="pagination">
                @if($specialties->currentPage() !== 1)
                    <li><a href="{{ $specialties->url(($specialties->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $specialties->lastPage(); $i++)
                    @if($specialties->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $specialties->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($specialties->currentPage() !== $specialties->lastPage())
                    <li><a href="{{ $specialties->url(($specialties->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif