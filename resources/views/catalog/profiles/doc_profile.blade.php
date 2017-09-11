@if (!empty($profile))
<div class="row">
    <div class="col-xs-6">
        <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
    </div>
    <div class="col-xs-6">
        <div class="row">
            <h3>{{ $profile->name ?? ''}}</h3>
            <h3>{{ $profile->lastname ?? ''}}</h3>
            <hr>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-lg-3"><h5>Специализация: </h5></div>
                    <div class="col-lg-9"><h5>{{ $profile->specialties->implode('name', ', ') ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Опыт: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->expirience ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Адрес: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->address ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Телефон: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->phone ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>E-mail: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->email ?? ''}}</h5></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><h5>Сайт: </h5></div>
                <div class="col-lg-9"><h5>{{ $profile->site ?? ''}}</h5></div>
            </div>
            <hr>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8">
        <h3>О враче</h3>
        {{ $profile->content ?? ''}}
    </div>
    <div class="col-xs-4">
        <div class="row">
            <h3>Место работы:</h3>
            {{ $profile->job ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Расписание:</h3>
            {{ $profile->shedule ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Категория:</h3>
            {{ $profile->category ?? ''}}
            <hr>
        </div>
        <div class="row">
            <h3>Услуги:</h3>
            @if(!empty($profile->services) && is_array($profile->services))
                <ul>
                    @foreach($profile->services as $service)
                        <li>{{ $service }}</li>
                    @endforeach
                </ul>
            @endif
            <hr>
        </div>
    </div>
</div>
    @if($blogs)
    <div class="row">
        @foreach($blogs as $blog)
            <div class="row">
                <div class="col-md-6">
                    {{ Html::image(asset('/images/blog/small') . '/' . $blog->blog_img->path, $blog->blog_img->alt, ['title' => $blog->blog_img->title]) }}
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <span>{{ $blog->category->name }}</span> <span class="label label-default">{{ $blog->created }}</span>
                    </div>
                    <h2>{{ $blog->title }}</h2>
                    <h5>{{ $profile->name . ' ' . $profile->lastname }}</h5>
                    <p>
                        {!! Form::open(['url' => route('blogs',['blog'=> $blog->alias]),'class'=>'form-horizontal','method'=>'GET']) !!}
                        {!! Form::button(trans('ru.more'), ['class' => 'btn btn-basic','type'=>'submit']) !!}
                        {!! Form::close() !!}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    @endif
@endif