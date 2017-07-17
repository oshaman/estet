<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_profile'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    <h3>Поиск профиля:</h3>
    <div class="row">
        {{ Form::label('value', 'Параметр') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('param', 'Критерий поиска') }}
        {!! Form::select('param',
                [
                    1=>'ID',
                    2=>'Link',
                    3=>'Все',
                ], old('val') ? : 1, ['class'=>'custom-select'])
!!}
    </div>
    <div class="row">
        {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
    {!! Form::close() !!}
</div>
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th>Имя</th><th>Фамилия</th><th>Телефон</th>
        </tr>
        </thead>
        @if (!empty($profiles))
            <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->lastname }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>
                        {!! Form::open(['url' => route('edit_profiles',['profile_id'=> $profile->user_id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        @endif
    </table>
</div>
<!-- END CONTENT -->