<!-- START CONTENT -->
<div class="container">
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
    {!! Form::open([
            'url'=>route('permissions'),
            'class'=>'form-horizontal',
            'method'=>'POST'
        ])
    !!}
    <div class="page type-page status-publish hentry group">
        <table class="table">
            <thead>
            <th>{{ trans('ru.permissions') }} \ {{ trans('admin.roles') }}</th>
            @if(!$roles->isEmpty())
                @foreach($roles as $item)
                    <th>{{ trans('ru.'.$item->name) }}</th>
                @endforeach
            @endif
            </thead>
            <tbody>
            @if(!$priv->isEmpty())
                @foreach($priv as $val)
                    <tr>
                        <td>{{ trans('ru.'.$val->name) }}</td>
                        @foreach($roles as $role)
                            <td>
                                @if($role->hasPermission($val->name))
                                    <input checked name="{{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                @else
                                    <input name=" {{ $role->id }}[]"  type="checkbox" value="{{ $val->id }}">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <!-- Submit -->
    {!! Form::button(trans('admin.save'), ['class' => 'btn btn-danger','type'=>'submit']) !!}

    {!! Form::close() !!}
</div>
<!-- END CONTENT -->