<h3>Менеджмент мероприятий</h3>
{!! Form::open(['url' => route('events_admin'), 'class'=>'form-horizontal','method'=>'GET' ]) !!}
<div class="row">
    {{ Form::label('value', 'Параметр поиска') }}
    {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'ID...', 'id'=>'value', 'class'=>'form-control']) !!}
    {{ Form::label('param', 'Критерий поиска') }}
    {!! Form::select('param', [1=>'Псевдоним', 2=>'ID Организатора', 3=>'ID Категории'], old('param') ? : '', ['class'=>'form-control']) !!}
</div>
<hr>
<div class="row">
    {!! Form::button(trans('admin.find'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
</div>
{!! Form::close() !!}
<hr>
@if(!empty($events))
    <table class="table">
        <thead>
        <tr><th>Название</th><th>Начало</th><th>Конец</th><th>Редактировать</th><th>Удалить</th></tr>
        </thead>
        <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->start }}</td>
                <td>{{ $event->stop }}</td>
                <td>
                    {!! Form::open(['url' => route('edit_event',['$event'=> $event->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.edit_btn'), ['class' => 'btn btn-warning','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    {!! Form::open(['url' => route('delete_event',['event'=> $event->id]),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('admin.delete'), ['class' => 'btn btn-danger','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if(is_object($events) && !empty($events->lastPage()) && $events->lastPage() > 1)
            <ul class="pagination">
                @if($events->currentPage() !== 1)
                    <li><a href="{{ $events->url(($events->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $events->lastPage(); $i++)
                    @if($events->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $events->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($events->currentPage() !== $events->lastPage())
                    <li><a href="{{ $events->url(($events->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif