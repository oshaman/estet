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
        <table class="table">
            <thead>
            <th>ID</th>
            <th>{{ trans('ru.email') }}</th>
            <th>{{ trans('admin.roles') }}</th>
            <th>{{ trans('admin.edit_btn') }}</th>
            <th>{{ trans('admin.delete') }}</th>
            </thead>
            <tbody>
            @if($users)
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->implode('name', ', ') }}</td>
                        <td>
                            {!! Form::open(['url' => route('user_update',['users'=> $user->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                            {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        <td>
                            {!! Form::open(['url' => route('delete_user',['users'=> $user->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                            {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach

            @endif
            </tbody>
        </table>
    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($users->lastPage() > 1)
            <ul class="pagination">
            @if($users->currentPage() !== 1)
                <li><a href="{{ $users->url(($users->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
            @endif

            @for($i = 1; $i <= $users->lastPage(); $i++)
                @if($users->currentPage() == $i)
                    <li><a class="selected disabled">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $users->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            @if($users->currentPage() !== $users->lastPage())
                <li><a href="{{ $users->url(($users->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
            @endif
            </ul>

        @endif

    </div>
</div>
<!-- END users -->