<!-- START CONTENT -->
<div class="conteiner">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <p class="error">
                @foreach ($errors->toArray() as $key=>$error)
                {!! str_replace($key, '<strong>' . trans('admin.' . $key) . '</strong>', $error[0]) !!}</br>
                @endforeach
            </p>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        {!! Form::open(['url' => route('user_update', $user->id),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
        <fieldset>
            <ul list-group>
                <li>
                    <h4>{!! Form::label('email', trans('ru.email')) !!}</h4>

                        {!! Form::text('email', old('email') ? : $user->email) !!}

                </li>
                <li>
                    <h4>{!! Form::label('pass', trans('ru.password')) !!}</h4>
                        {!! Form::password('password') !!}
                </li>
                <li>
                    <h4>{!! Form::label('cpass', trans('ru.cpassword')) !!}</h4>
                        {!! Form::password('password_confirmation') !!}
                </li>

                <li>
                    <h4>{!! Form::label('roles', trans('ru.roles')) !!}</h4>
                    <table class="table">
                        @foreach($roles as $id=>$role)
                            @if($user->hasRole($role))
                                <td>
                                    <input checked name="role_id[]"  type="checkbox" value="{{ $id }}">{{trans('ru.' . $role) }}
                                </td>
                            @else
                                <td>
                                    <input name="role_id[]"  type="checkbox" value="{{ $id }}">{{ trans('ru.' . $role) }}
                                </td>
                            @endif
                        @endforeach
                    </table>
                </li>
            </ul>
        </fieldset>
        <!-- Submit -->
        {!! Form::button(trans('admin.save'), ['class' => 'btn btn-success','type'=>'submit']) !!}
        {!! Form::close() !!}
</div>
<!-- END CONTENT -->