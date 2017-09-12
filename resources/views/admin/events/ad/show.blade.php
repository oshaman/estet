<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Картинка</th>
        <th>Заголовок</th>
        <th>Ссылка</th>
    </tr>
    </thead>
    @if (!empty($advertisings[0]))
        <tbody>
        @foreach ($advertisings as $advertising)
            <tr>
                <td>{{ $advertising->id }}</td>
                <td>
                    @if(!empty($advertising->image))
                        <img src="{{ asset('images/event/ad/small') . '/' . $advertising->image }}"
                             class="img-thumbnail">
                    @endif
                </td>
                <td>{{ $advertising->title }}</td>
                <td>{{ $advertising->extlink }}</td>
                <td>
                    {!! Form::open(['url' => route('update_events_slider',['advertising'=> $advertising->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(['url' => route('del_events_slider',['advertising'=> $advertising->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>