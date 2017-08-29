@if(!empty($articles))
    <div class="row">
        <div class="row">
            <div class="col-lg-9">
                <div class="col-lg-6"><img src="{{ asset('/images/article/main').'/'.$articles['lasts'][0]->path }}" class="img-thumbnail"></div>
                <div class="col-lg-6">
                    <div class="row">{{ $articles['lasts'][0]->name }} <span class="label label-default navbar-right">{{ $articles['lasts'][0]->created }}</span></div>
                    <h3>{{ $articles['lasts'][0]->title }}</a> </h3>
                    {!! Form::open(['url' => route('articles',$articles['lasts'][0]->alias),'class'=>'form-horizontal','method'=>'GET']) !!}
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
    <div class="row">
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

@endif