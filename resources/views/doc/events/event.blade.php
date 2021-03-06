<h1>{{ $event->title }}</h1>
<div class="thumbnail">
    {{ Html::image(asset('/images/event/main') . '/' . $event->logo->path, $event->logo->alt, ['title' => $event->logo->title]) }}
</div>
<div class="row">{{ $event->description }}</div>
<hr>
{{--Slider--}}
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach($event->slider as $slider)
            @if ($loop->first)
                <div class="item active">
                    @else
                        <div class="item">
                            @endif
                            <img src="{{ asset('/images/event/slider/main') . '/' . $slider->path }}"
                                 alt="{{ $slider->alt }}" title="{{ $slider->title }}">
                        </div>
                        @endforeach
                </div>
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Next</span>
                </a>
    </div>
    {{--Slider--}}
    <hr>
    <div class="row">
        {!! $event->content !!}
    </div>
    <hr>
    @if(count($event->comments) > 0)
        <hr>
        @foreach($event->comments as $comment)
            @if(0 !== $comment->parent_id)
                @continue
            @endif
            <div class="row">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>{{ $comment->id }}</th>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>{{ $comment->email }}</td>
                    </tr>
                    <tr>
                        <td>Имя</td>
                        <td>{{ $comment->name }}</td>
                    </tr>
                    <tr>
                        <td>Коментарий</td>
                        <td>{{ $comment->text }}</td>
                    </tr>
                </table>
            </div>
            @include('comment', ['children' => $event->comments, 'id' => $comment->id])
        @endforeach
    @endif
    <hr>
    <div class="row">
        <h4>Добавить коментарий</h4>
        <div class="row">
            {!! Form::open(['url' => route('comments'),'class'=>'form-horizontal','method'=>'post']) !!}
            {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Ваша почта', 'id'=>'email', 'class'=>'form-control']) !!}
            {!! Form::text('name', old('name') ? : '' , ['placeholder'=>'Имя', 'id'=>'name', 'class'=>'form-control']) !!}
            {!! Form::textarea('text', old('text') ? : '' , ['placeholder'=>'Коментарий', 'id'=>'text', 'class'=>'form-control', 'rows'=>5, 'cols'=>50]) !!}
            {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
            {{ Form::hidden('comment_post_ID', $event->id) }}
            {{ Form::hidden('comment_parent', 0) }}
            {{ Form::hidden('comment_source', 4) }}
            {!! Form::close() !!}
        </div>
    </div>
    <hr>
    @if(!empty($similars))
        <div class="row">
            <div class="col-lg-4">
                <img src="{{ asset('images\event\mini').'/'. $similars[0]->logo->path}}">
                <p><span class="label label-default">{{ $similars[0]->created}}</span></p>
                <a href="{{ route('events', $similars[0]->alias) }}">{{ $similars[0]->title}}</a>
            </div>
            <div class="col-lg-4">
                @if(!empty($similars[1]))
                    <img src="{{ asset('images\event\mini').'/'. $similars[1]->logo->path}}">
                    <p><span class="label label-default">{{ $similars[1]->created}}</span></p>
                    <a href="{{ route('events', $similars[1]->alias) }}">{{ $similars[1]->title}}</a>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($similars[2]))
                    <img src="{{ asset('images\event\mini').'/'. $similars[2]->logo->path}}">
                    <p><span class="label label-default">{{ $similars[2]->created}}</span></p>
                    <a href="{{ route('events', $similars[2]->alias) }}">{{ $similars[2]->title}}</a>
                @endif
            </div>
        </div>
        <hr>
@endif