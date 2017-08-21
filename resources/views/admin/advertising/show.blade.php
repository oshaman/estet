<table class="table">
    <thead>
    <tr>
        <th>Размещение</th>
        <th>Раздел</th>
    </tr>
    </thead>
    @if (!empty($advertisings[0]))
        <tbody>
        @foreach ($advertisings as $advertising)
            <tr>
                <td>{{ trans('ru.'. $advertising->placement) }}</td>
                <td>{{ trans('ru.'. $advertising->own) }}</td>
                <td>
                    {!! Form::open(['url' => route('advertising_update',['advertising'=> $advertising->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>