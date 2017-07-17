<!-- START CONTENT -->
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
<!-- END CONTENT -->