<h3>Менеджмент городов</h3>
{!! Form::open(['url' => route('city'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
<div class="row">
    {{ Form::label('param', 'Выбрать страну') }}
    {!! Form::select('param', $countries, old('param') ? : '', ['class'=>'form-control']) !!}
</div>
<div class="row">
    {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
</div>
{!! Form::close() !!}
<hr>
<div class="row">
    {!! Form::open(['url' => route('create_city'),'class'=>'form-horizontal','method'=>'GET']) !!}
    {!! Form::button('Добавить город', ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
<hr>
@if(!empty($cities))
    <table class="table">
        <thead>
        <tr><th>Имя</th><th>Редактировать</th><th>Удалить</th></tr>
        </thead>
        <tbody>
        @foreach($cities as $city)
            <tr>
                <td>{{ $city->name }}</td>
                <td>
                    {!! Form::open(['url' => route('edit_city',['$city'=> $city->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(['url' => route('delete_city',['city'=> $city->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($cities->lastPage() > 1)
            <ul class="pagination">
                @if($cities->currentPage() !== 1)
                    <li><a href="{{ $cities->url(($cities->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $cities->lastPage(); $i++)
                    @if($cities->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $cities->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($cities->currentPage() !== $cities->lastPage())
                    <li><a href="{{ $cities->url(($cities->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif