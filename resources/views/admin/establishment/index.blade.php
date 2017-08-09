<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_establishment'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    <h3>Поиск учреждения:</h3>
    <div class="row">
        {{ Form::label('value', 'Параметр') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        {!! Form::select('param',
                [
                    1=>'Псевдоним',
                    2=>'ID',
                    3=>'Все',
                ], old('val') ? : 1, ['class'=>'custom-select'])
!!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
<hr>
<div class="row">
    {!! Html::link(route('create_establishments'),'Создать учреждение',['class' => 'btn btn-success']) !!}
</div>
<hr>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Название</th><th>Категория</th><th>Телефон</th>
        </tr>
        </thead>
        @if (!empty($profiles))
            <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td>{{ $profile->title }}</td>
                    <td>{{ trans('admin.' . $profile->category) }}</td>
                    <td>{{ $profile->phones }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_establishment',['profile_id'=> $profile->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                    <td>
                        {!! Form::open(['url' => route('delete_establishment',['establishment'=> $profile->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <!--PAGINATION-->

            <div class="general-pagination group">

                @if(is_object($profiles) && !empty($profiles->lastPage()) && $profiles->lastPage() > 1)
                    <ul class="pagination">
                        @if($profiles->currentPage() !== 1)
                            <li><a href="{{ $profiles->url(($profiles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                        @endif

                        @for($i = 1; $i <= $profiles->lastPage(); $i++)
                            @if($profiles->currentPage() == $i)
                                <li><a class="selected disabled">{{ $i }}</a></li>
                            @else
                                <li><a href="{{ $profiles->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if($profiles->currentPage() !== $profiles->lastPage())
                            <li><a href="{{ $profiles->url(($profiles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                        @endif
                    </ul>

                @endif

            </div>
        @endif
    </table>
</div>
<!-- END CONTENT -->