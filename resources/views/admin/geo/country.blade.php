<h3>Менеджмент стран</h3>
<div class="row">
    {!! Form::open(['url' => route('create_country'),'class'=>'form-horizontal','method'=>'GET']) !!}
    {!! Form::button('Добавить страну', ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
<hr>
@if(!empty($countries))
    <table class="table">
        <thead>
        <tr><th>Имя</th><th>Редактировать</th></tr>
        </thead>
        <tbody>
        @foreach($countries as $country)
            <tr>
                <td>{{ $country->name }}</td>
                <td>
                    {!! Form::open(['url' => route('edit_country',['$country'=> $country->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(['url' => route('delete_country',['country'=> $country->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($countries->lastPage() > 1)
            <ul class="pagination">
                @if($countries->currentPage() !== 1)
                    <li><a href="{{ $countries->url(($countries->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $countries->lastPage(); $i++)
                    @if($countries->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $countries->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($countries->currentPage() !== $countries->lastPage())
                    <li><a href="{{ $countries->url(($countries->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif