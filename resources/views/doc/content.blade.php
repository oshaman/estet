@if(!empty($articles))
    <div class="row bg-warning">
        <div class="row">
            <div class="col-lg-9">
                <div class="col-lg-6"><img src="{{ asset('/images/article/main').'/'.$articles['lasts'][0]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-6">
                    <div class="row">{{ $articles['lasts'][0]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][0]->created }}</span></div>
                    <h3>{{ $articles['lasts'][0]->title }}</a> </h3>
                    <p>{!! str_limit($articles['lasts'][0]->content, 200) !!}</p>
                    {!! Form::open(['url' => route('doctors',$articles['lasts'][0]->alias),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-3">
                Реклама
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][1]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][1]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['lasts'][1]->alias) }}"> {{ $articles['lasts'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][2]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][2]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['lasts'][2]->alias) }}"> {{ $articles['lasts'][2]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][3]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][3]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][3]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][3]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['lasts'][3]->alias) }}"> {{ $articles['lasts'][3]->title }}</a> </h3>
                @endif
            </div>
        </div>
    </div>
    <hr>
    <div class="row bg-success">
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['popular'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['popular'][0]->created }}</span></p>
            <h3><a href="{{ route('doctors', $articles['popular'][0]->alias) }}"> {{ $articles['popular'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][1]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][1]->created }}</span></p>
                    <h3><a href="{{ route('doctors', $articles['popular'][1]->alias) }}"> {{ $articles['popular'][1]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][2]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][2]->created }}</span></p>
                    <h3><a href="{{ route('doctors', $articles['popular'][2]->alias) }}"> {{ $articles['popular'][2]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][3]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][3]->created }}</span></p>
                    <h3><a href="{{ route('doctors', $articles['popular'][3]->alias) }}"> {{ $articles['popular'][3]->title }}</a> </h3>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row bg-info">
        @if(!empty($articles['video']))
            <div class="col-lg-4">
                @if(!empty($articles['video'][0]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['video'][0]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['video'][0]->name }} <span class="label label-default navbar-right">{{ $articles['video'][0]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['video'][0]->alias) }}"> {{ $articles['video'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['video'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['video'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['video'][1]->name }} <span class="label label-default navbar-right">{{ $articles['video'][1]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['video'][1]->alias) }}"> {{ $articles['video'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['video'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['video'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['video'][2]->name }} <span class="label label-default navbar-right">{{ $articles['video'][2]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['video'][2]->alias) }}"> {{ $articles['video'][2]->title }}</a> </h3>
                @endif
            </div>
    </div>
        {!! Form::open(['url' => route('docs_cat',$articles['video'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
        {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
        {!! Form::close() !!}
        <hr>
    @endif
    <div class="row bg-success">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['experts'][0]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['experts'][0]->created }}</span></p>
                    <h3><a href="{{ route('doctors', $articles['experts'][0]->alias) }}"> {{ $articles['experts'][0]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            @if(!empty($articles['experts'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['experts'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['experts'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['experts'][1]->alias) }}"> {{ $articles['experts'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['experts'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['experts'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['experts'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['experts'][2]->alias) }}"> {{ $articles['experts'][2]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-5 col-lg-offset-1">
            <div class="row">
                <h3>Подписаться на рассылку</h3>
                {!! Form::open(['url'=>route('subscribe')]) !!}
                {!! Form::text('email', old('email') ? : '' , ['placeholder'=>'Email', 'id'=>'email', 'class'=>'form-control']) !!}
                <div class="row">
                    {{ Form::label('status', 'Принадлежность') }}
                    <div>
                        {!! Form::select('status', [0=>'Пациент', 1=>'Доктор'],
                            old('status') ? : '' , [ 'class'=>'form-control', 'placeholder'=>'Доктор\Пациент'])
                        !!}
                    </div>
                    <hr>
                    {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <hr>
    <div class="row bg-success">
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['cosmetology'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['cosmetology'][0]->created }}</span></p>
            <h3><a href="{{ route('doctors', $articles['cosmetology'][0]->alias) }}"> {{ $articles['cosmetology'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['cosmetology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['cosmetology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['cosmetology'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['cosmetology'][1]->alias) }}"> {{ $articles['cosmetology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['cosmetology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['cosmetology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['cosmetology'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['cosmetology'][2]->alias) }}"> {{ $articles['cosmetology'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['cosmetology'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['cosmetology'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['cosmetology'][3]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['cosmetology'][3]->alias) }}"> {{ $articles['cosmetology'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['cosmetology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-info">
        @if(!empty($articles['events']))
            <div class="col-lg-4">
                @if(!empty($articles['events'][0]))
                    <img src="{{ asset('/images/event/mini').'/'.$articles['events'][0]->logo->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['events'][0]->name }} <span class="label label-default navbar-right">{{ $articles['events'][0]->created }}</span></div>
                    <h3><a href="{{ route('events', $articles['events'][0]->alias) }}"> {{ $articles['events'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['events'][1]))
                    <img src="{{ asset('/images/event/mini').'/'.$articles['events'][1]->logo->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['events'][1]->name }} <span class="label label-default navbar-right">{{ $articles['events'][1]->created }}</span></div>
                    <h3><a href="{{ route('events', $articles['events'][1]->alias) }}"> {{ $articles['events'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['events'][2]))
                    <img src="{{ asset('/images/event/mini').'/'.$articles['events'][2]->logo->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['events'][2]->name }} <span class="label label-default navbar-right">{{ $articles['events'][2]->created }}</span></div>
                    <h3><a href="{{ route('events', $articles['events'][2]->alias) }}"> {{ $articles['events'][2]->title }}</a> </h3>
                @endif
            </div>
    </div>
    {!! Form::open(['url' => route('events'),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-success">
    @if(!empty($articles['dermatology'][0]))
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['dermatology'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['dermatology'][0]->created }}</span></p>
            <h3><a href="{{ route('doctors', $articles['dermatology'][0]->alias) }}"> {{ $articles['dermatology'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['dermatology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['dermatology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['dermatology'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['dermatology'][1]->alias) }}"> {{ $articles['dermatology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['dermatology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['dermatology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['dermatology'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['dermatology'][2]->alias) }}"> {{ $articles['dermatology'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['dermatology'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['dermatology'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['dermatology'][3]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['dermatology'][3]->alias) }}"> {{ $articles['dermatology'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['dermatology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-info">
    @if(!empty($articles['practic']))
        <div class="col-lg-4">
            @if(!empty($articles['practic'][0]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['practic'][0]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['practic'][0]->name }} <span class="label label-default navbar-right">{{ $articles['practic'][0]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['practic'][0]->alias) }}"> {{ $articles['practic'][0]->title }}</a> </h3>
            @endif
        </div>
        <div class="col-lg-4">
            @if(!empty($articles['practic'][1]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['practic'][1]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['practic'][1]->name }} <span class="label label-default navbar-right">{{ $articles['practic'][1]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['practic'][1]->alias) }}"> {{ $articles['practic'][1]->title }}</a> </h3>
            @endif
        </div>
        <div class="col-lg-4">
            @if(!empty($articles['practic'][2]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['practic'][2]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['practic'][2]->name }} <span class="label label-default navbar-right">{{ $articles['practic'][2]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['practic'][2]->alias) }}"> {{ $articles['practic'][2]->title }}</a> </h3>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['practic'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-success">
    @if(!empty($articles['plastic'][0]))
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['plastic'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['plastic'][0]->created }}</span></p>
            <h3><a href="{{ route('doctors', $articles['plastic'][0]->alias) }}"> {{ $articles['plastic'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['plastic'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['plastic'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['plastic'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['plastic'][1]->alias) }}"> {{ $articles['plastic'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['plastic'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['plastic'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['plastic'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['plastic'][2]->alias) }}"> {{ $articles['plastic'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['plastic'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['plastic'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['plastic'][3]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['plastic'][3]->alias) }}"> {{ $articles['plastic'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['plastic'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-info">
    @if(!empty($articles['endocrinology']))
        <div class="col-lg-4">
            @if(!empty($articles['endocrinology'][0]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['endocrinology'][0]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['endocrinology'][0]->name }} <span class="label label-default navbar-right">{{ $articles['endocrinology'][0]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['endocrinology'][0]->alias) }}"> {{ $articles['endocrinology'][0]->title }}</a> </h3>
            @endif
        </div>
        <div class="col-lg-4">
            @if(!empty($articles['endocrinology'][1]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['endocrinology'][1]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['endocrinology'][1]->name }} <span class="label label-default navbar-right">{{ $articles['endocrinology'][1]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['endocrinology'][1]->alias) }}"> {{ $articles['endocrinology'][1]->title }}</a> </h3>
            @endif
        </div>
        <div class="col-lg-4">
            @if(!empty($articles['endocrinology'][2]))
                <img src="{{ asset('/images/article/mini').'/'.$articles['endocrinology'][2]->path }}" class="img-thumbnail">
                <div class="row">{{ $articles['endocrinology'][2]->name }} <span class="label label-default navbar-right">{{ $articles['endocrinology'][2]->created }}</span></div>
                <h3><a href="{{ route('doctors', $articles['endocrinology'][2]->alias) }}"> {{ $articles['endocrinology'][2]->title }}</a> </h3>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['endocrinology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-success">
    @if(!empty($articles['stomatology'][0]))
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['stomatology'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['stomatology'][0]->created }}</span></p>
            <h3><a href="{{ route('doctors', $articles['stomatology'][0]->alias) }}"> {{ $articles['stomatology'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['stomatology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['stomatology'][1]->alias) }}"> {{ $articles['stomatology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['stomatology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['stomatology'][2]->alias) }}"> {{ $articles['stomatology'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['stomatology'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][3]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['stomatology'][3]->alias) }}"> {{ $articles['stomatology'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('docs_cat',$articles['stomatology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    @endif
    <div class="row bg-info">
        <div class="col-lg-6">
            @if(!empty($articles['venerology'][0]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['venerology'][0]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['venerology'][0]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['venerology'][0]->alias) }}"> {{ $articles['venerology'][0]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @if(!empty($articles['venerology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['venerology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['venerology'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['venerology'][1]->alias) }}"> {{ $articles['venerology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['venerology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['venerology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['venerology'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['venerology'][2]->alias) }}"> {{ $articles['venerology'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
                    {!! Form::open(['url' => route('docs_cat',$articles['venerology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
                    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
                    {!! Form::close() !!}
            @endif
        </div>
        <div class="col-lg-6">
            @if(!empty($articles['urology'][0]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['urology'][0]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['urology'][0]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['urology'][0]->alias) }}"> {{ $articles['urology'][0]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @if(!empty($articles['urology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['urology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['urology'][1]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['urology'][1]->alias) }}"> {{ $articles['urology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['urology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['urology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['urology'][2]->created }}</span></p>
                        <h3><a href="{{ route('doctors', $articles['urology'][2]->alias) }}"> {{ $articles['urology'][2]->title }}</a> </h3>
                    </div>
                </div>
            @endif
                    {!! Form::open(['url' => route('docs_cat',$articles['venerology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
                    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
                    {!! Form::close() !!}
                <hr>
            @endif
        </div>
    </div>
    <div class="row bg-info">
        @if(!empty($articles['trihology']))
            @if(!empty($articles['trihology'][0]))
            <div class="col-lg-4">
                    <img src="{{ asset('/images/article/mini').'/'.$articles['trihology'][0]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['trihology'][0]->name }} <span class="label label-default navbar-right">{{ $articles['trihology'][0]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['trihology'][0]->alias) }}"> {{ $articles['trihology'][0]->title }}</a> </h3>
            </div>
            @endif
            <div class="col-lg-4">
                @if(!empty($articles['trihology'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['trihology'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['trihology'][1]->name }} <span class="label label-default navbar-right">{{ $articles['trihology'][1]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['trihology'][1]->alias) }}"> {{ $articles['trihology'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['trihology'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['trihology'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['trihology'][2]->name }} <span class="label label-default navbar-right">{{ $articles['trihology'][2]->created }}</span></div>
                    <h3><a href="{{ route('doctors', $articles['trihology'][2]->alias) }}"> {{ $articles['trihology'][2]->title }}</a> </h3>
                @endif
            </div>
    </div>
        {!! Form::open(['url' => route('docs_cat',$articles['trihology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
        {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
        {!! Form::close() !!}
    <hr>
    @endif
@endif