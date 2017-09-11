@foreach($children as $child)
    @if(0 == $child->id)
        @continue
    @endif
    @if($child->parent_id != $id)
        @continue
    @endif
        <div class="row bg-info">
            <table class="table">
                <tr><th>#</th><th>{{ $child->id }}</th></tr>
                <tr><td>E-mail</td><td>{{ $child->email }}</td></tr>
                <tr><td>Имя</td><td>{{ $child->name }}</td></tr>
                <tr><td>Коментарий</td><td>{{ $child->text }}</td></tr>
            </table>
        </div>
@endforeach