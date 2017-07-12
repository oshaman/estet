<!-- START CONTENT -->
<div class="container">
    {!! Form::open(['url' => route('admin_profile'), 'class'=>'form-horizontal','method'=>'POST' ]) !!}
    <div class="row">
        {{ Form::label('value', 'Поиск профиля') }}
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'id, link...', 'id'=>'value', 'class'=>'form-control']) !!}
        {{ Form::label('val', 'Критерий поиска') }}
        {!! Form::select('val',
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
            <th>Имя</th><th>Фамилия</th><th>Телефон</th><th>Специальность</th>
        </tr>
        </thead>
        @if (!empty($profiles))
            <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td>{{ $profile->name }}</td>
                    <td>{{ $profile->lastname }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>{{ $profile->specialty }}</td>
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