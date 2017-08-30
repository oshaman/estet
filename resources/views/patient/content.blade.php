@if(!empty($articles))
    <div class="row bg-warning">
        <div class="row">
            <div class="col-lg-9">
                <div class="col-lg-6"><img src="{{ asset('/images/article/main').'/'.$articles['lasts'][0]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-6">
                    <div class="row">{{ $articles['lasts'][0]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][0]->created }}</span></div>
                    <h3>{{ $articles['lasts'][0]->title }}</a> </h3>
                    <p>{!! str_limit($articles['lasts'][0]->content, 200) !!}</p>
                    {!! Form::open(['url' => route('articles',$articles['lasts'][0]->alias),'class'=>'form-horizontal','method'=>'GET']) !!}
                    {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-lg-3">
                {!! $advertising ?? '<img src="'. asset('estet/img') .'/zastavka.jpg" >' !!}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][1]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][1]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['lasts'][1]->alias) }}"> {{ $articles['lasts'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][2]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][2]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['lasts'][2]->alias) }}"> {{ $articles['lasts'][2]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['lasts'][3]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['lasts'][3]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['lasts'][3]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][3]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['lasts'][3]->alias) }}"> {{ $articles['lasts'][3]->title }}</a> </h3>
                @endif
            </div>
        </div>
    </div>
    <hr>
    <div class="row bg-success">
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['popular'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['popular'][0]->created }}</span></p>
            <h3><a href="{{ route('articles', $articles['popular'][0]->alias) }}"> {{ $articles['popular'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][1]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][1]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['popular'][1]->alias) }}"> {{ $articles['popular'][1]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][2]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][2]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['popular'][2]->alias) }}"> {{ $articles['popular'][2]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['popular'][3]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['popular'][3]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['popular'][3]->alias) }}"> {{ $articles['popular'][3]->title }}</a> </h3>
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
                    <h3><a href="{{ route('articles', $articles['video'][0]->alias) }}"> {{ $articles['video'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['video'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['video'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['video'][1]->name }} <span class="label label-default navbar-right">{{ $articles['video'][1]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['video'][1]->alias) }}"> {{ $articles['video'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['video'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['video'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['video'][2]->name }} <span class="label label-default navbar-right">{{ $articles['video'][2]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['video'][2]->alias) }}"> {{ $articles['video'][2]->title }}</a> </h3>
                @endif
            </div>
        @endif
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['video'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-success">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['facts'][0]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['facts'][0]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['facts'][0]->alias) }}"> {{ $articles['facts'][0]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            @if(!empty($articles['facts'][1]))
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['facts'][1]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['facts'][1]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['facts'][1]->alias) }}"> {{ $articles['facts'][1]->title }}</a> </h3>
                </div>
            </div>
                <hr>
            @endif
            @if(!empty($articles['facts'][2]))
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['facts'][2]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['facts'][2]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['facts'][2]->alias) }}"> {{ $articles['facts'][2]->title }}</a> </h3>
                </div>
            </div>
            <hr>
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
            <img src="{{ asset('/images/article/main').'/'.$articles['diet'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['diet'][0]->created }}</span></p>
            <h3><a href="{{ route('articles', $articles['diet'][0]->alias) }}"> {{ $articles['diet'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['diet'][1]))
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['diet'][1]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['diet'][1]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['diet'][1]->alias) }}"> {{ $articles['diet'][1]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            @endif
            @if(!empty($articles['diet'][2]))
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['diet'][2]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['diet'][2]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['diet'][2]->alias) }}"> {{ $articles['diet'][2]->title }}</a> </h3>
                </div>
            </div>
            <hr>
            @endif
            @if(!empty($articles['diet'][3]))
            <div class="row">
                <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['diet'][3]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-7 col-lg-offset-1">
                    <p><span class="label label-default">{{ $articles['diet'][3]->created }}</span></p>
                    <h3><a href="{{ route('articles', $articles['diet'][3]->alias) }}"> {{ $articles['diet'][3]->title }}</a> </h3>
                </div>
            </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['diet'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-info">
        @if(!empty($articles['beauty']))
            <div class="col-lg-4">
                @if(!empty($articles['beauty'][0]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['beauty'][0]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['beauty'][0]->name }} <span class="label label-default navbar-right">{{ $articles['beauty'][0]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['beauty'][0]->alias) }}"> {{ $articles['beauty'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['beauty'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['beauty'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['beauty'][1]->name }} <span class="label label-default navbar-right">{{ $articles['beauty'][1]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['beauty'][1]->alias) }}"> {{ $articles['beauty'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['beauty'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['beauty'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['beauty'][2]->name }} <span class="label label-default navbar-right">{{ $articles['beauty'][2]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['beauty'][2]->alias) }}"> {{ $articles['beauty'][2]->title }}</a> </h3>
                @endif
            </div>
        @endif
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['beauty'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    {{--Реклама--}}
    <div class="row">
        {!! $advertising ?? '<img src="'. asset('estet/img') .'/your-ad-here.jpg" class="img-thumbnail">' !!}
    </div>
    <hr>
    {{--Реклама--}}
    <div class="row bg-success">
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['medicine'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['medicine'][0]->created }}</span></p>
            <h3><a href="{{ route('articles', $articles['medicine'][0]->alias) }}"> {{ $articles['medicine'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['medicine'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['medicine'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['medicine'][1]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['medicine'][1]->alias) }}"> {{ $articles['medicine'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['medicine'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['medicine'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['medicine'][2]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['medicine'][2]->alias) }}"> {{ $articles['medicine'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['medicine'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['medicine'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['medicine'][3]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['medicine'][3]->alias) }}"> {{ $articles['medicine'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['medicine'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-info">
        @if(!empty($articles['advice']))
            <div class="col-lg-4">
                @if(!empty($articles['advice'][0]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['advice'][0]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['advice'][0]->name }} <span class="label label-default navbar-right">{{ $articles['advice'][0]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['advice'][0]->alias) }}"> {{ $articles['advice'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['advice'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['advice'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['advice'][1]->name }} <span class="label label-default navbar-right">{{ $articles['advice'][1]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['advice'][1]->alias) }}"> {{ $articles['advice'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['advice'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['advice'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['advice'][2]->name }} <span class="label label-default navbar-right">{{ $articles['advice'][2]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['advice'][2]->alias) }}"> {{ $articles['advice'][2]->title }}</a> </h3>
                @endif
            </div>
        @endif
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['advice'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-success">
        <div class="col-lg-5">
            <img src="{{ asset('/images/article/main').'/'.$articles['stomatology'][0]->path }}" class="img-thumbnail">
            <p><span class="label label-default navbar-right">{{ $articles['stomatology'][0]->created }}</span></p>
            <h3><a href="{{ route('articles', $articles['stomatology'][0]->alias) }}"> {{ $articles['stomatology'][0]->title }}</a> </h3>
        </div>
        <div class="col-lg-6 col-lg-offset-1">
            @if(!empty($articles['stomatology'][1]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][1]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][1]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['stomatology'][1]->alias) }}"> {{ $articles['stomatology'][1]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['stomatology'][2]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][2]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][2]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['stomatology'][2]->alias) }}"> {{ $articles['stomatology'][2]->title }}</a> </h3>
                    </div>
                </div>
                <hr>
            @endif
            @if(!empty($articles['stomatology'][3]))
                <div class="row">
                    <div class="col-lg-4"><img src="{{ asset('/images/article/mini').'/'.$articles['stomatology'][3]->path }}" class="img-thumbnail"></div>
                    <div class="col-lg-7 col-lg-offset-1">
                        <p><span class="label label-default">{{ $articles['stomatology'][3]->created }}</span></p>
                        <h3><a href="{{ route('articles', $articles['stomatology'][3]->alias) }}"> {{ $articles['stomatology'][3]->title }}</a> </h3>
                    </div>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['stomatology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
    <div class="row bg-info">
        @if(!empty($articles['psychology']))
            <div class="col-lg-4">
                @if(!empty($articles['psychology'][0]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['psychology'][0]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['psychology'][0]->name }} <span class="label label-default navbar-right">{{ $articles['psychology'][0]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['psychology'][0]->alias) }}"> {{ $articles['psychology'][0]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['psychology'][1]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['psychology'][1]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['psychology'][1]->name }} <span class="label label-default navbar-right">{{ $articles['psychology'][1]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['psychology'][1]->alias) }}"> {{ $articles['psychology'][1]->title }}</a> </h3>
                @endif
            </div>
            <div class="col-lg-4">
                @if(!empty($articles['psychology'][2]))
                    <img src="{{ asset('/images/article/mini').'/'.$articles['psychology'][2]->path }}" class="img-thumbnail">
                    <div class="row">{{ $articles['psychology'][2]->name }} <span class="label label-default navbar-right">{{ $articles['psychology'][2]->created }}</span></div>
                    <h3><a href="{{ route('articles', $articles['psychology'][2]->alias) }}"> {{ $articles['psychology'][2]->title }}</a> </h3>
                @endif
            </div>
        @endif
    </div>
    {!! Form::open(['url' => route('article_cat',$articles['psychology'][0]->cat_alias),'class'=>'form-horizontal navbar-right','method'=>'GET']) !!}
    {!! Form::button(trans('Перейти к разделу'), ['class' => 'btn btn-info','type'=>'submit']) !!}
    {!! Form::close() !!}
    <hr>
@endif