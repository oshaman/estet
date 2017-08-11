<h2>{{ trans('ru.clinics') }}---------------------------------------------------</h2>
<div class="row">
    <div class="col-lg-4">
        <div class="row">{{ Html::image(asset('/images/establishment/main') . '/' . $clinic->logo, $clinic->title, array('class' => 'img-thumbnail')) }}</div>
        <div class="row">***** оценка {{ ($ratio->avg ?? 0) .' / 5 - (' . $ratio->count . ' проголосовавших)'}}</div>
        <div class="d-block bg-info">
            <div><strong>Категория: </strong>{{ trans('ru.' . $clinic->category) }}</div>
            <div><strong>Телефоны: </strong>{{ $clinic->phones }}</div>
            <div><strong>Сайт: </strong>{{ $clinic->site }}</div>
            <div><strong>Спецификация: </strong>{{ $clinic->spec }}</div>
            @if(!empty($clinic->services))
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#service">Услуги: </a>
                    </h4>
                </div>
                <div id="service" class="panel-collapse collapse">
                    @foreach($clinic->services as $service)
                        <div class="panel-body">{{ $service }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row"><h2 class="text-center">{{ $clinic->title }}</h2></div>
        <hr>
        <div class="row">{{ $clinic->address }}</div>
        <h3>О нас</h3>
        <div class="row">{!! $clinic->about !!}</div>
    </div>
</div>
<hr>
@if(!empty($clinic->articles))
    <div class="row bg-warning">
        <h4>Публикации клиники ========================================</h4>
        @foreach($clinic->articles as $article)
            <a href="{{ route('articles', $article->alias) }}">{{ $article->title }}</a>
            <hr>
        @endforeach
    </div>
@endif