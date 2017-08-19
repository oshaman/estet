<table class="table">
    <thead>
    <tr>
        <th>Ссылка</th>
    </tr>
    </thead>
    @if (!empty($seos[0]))
        <tbody>
        @foreach ($seos as $seo)
            <tr>
                <td>{{ $seo->uri }}</td>
                <td>
                    {!! Form::open(['url' => route('seo_update',['seo'=> $seo->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>