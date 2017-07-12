{{ dump($profiles) }}
<!-- START CONTENT -->
<table class="table">
    <thead>
        <tr>
            <th>name</th><th>lastname</th><th>phone</th><th>specialty</th>
        </tr>
    </thead>
    @if (!empty($profiles))
    <tbody>
        @foreach ($profiles as $profile)
        <tr>
            <td>{{ $profile->name }}</td>
            <td>{{ $profile->lastname }}</td>
            <td>{{ $profile->phone }}</td>
            <td>{{ $profile->specialty }}</td>{{--
            <td>
                {!! Form::open(['url' => route('edit_profiles',['alias_profile'=> $user->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                {!! Form::close() !!}
            </td>--}}
        </tr>
        @endforeach
    </tbody>
    @endif
</table>
<!-- END CONTENT -->