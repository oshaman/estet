<table class="table">
    <thead>
    <tr>
        <th>Заголовок</th>
        <th>Страница</th>
    </tr>
    </thead>
    @if (!empty($pages[0]))
        <tbody>
        @foreach ($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ trans('ru.'. $page->own) }}</td>
                <td>
                    {!! Form::open(['url' => route('static_update',['static'=> $page->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>