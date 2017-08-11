<h2>{{ trans('ru.brands') }}---------------------------------------------------</h2>
<div class="col-lg-4">
    <div class="row">{{ Html::image(asset('/images/establishment/main') . '/' . $brand->logo, $brand->title, array('class' => 'img-thumbnail')) }}</div>
    <div class="d-block bg-info">
        <div><div class="col-lg-4"><strong>Категория: </strong></div><div class="col-lg-8">{{ $brand->category }}</div></div>
        <div><div class="col-lg-4"><strong>Телефоны: </strong></div><div class="col-lg-8">{{ $brand->phones }}</div></div>
        <div><div class="col-lg-4"><strong>Сайт: </strong></div><div class="col-lg-8">{{ $brand->site }}</div></div>
        @if(!empty($parent->alias))
            <div>
                <div class="col-lg-4"><strong>Головная компания: </strong></div>
                <div class="col-lg-8">
                    <a href="{{ route('distributors', $parent->alias) }}">{{ $parent->title }}</a>
                </div>
            </div>
        @endif
        @if(!empty($brand->services))
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#service">Услуги: </a>
                </h4>
            </div>
            <div id="service" class="panel-collapse collapse">
                @foreach($brand->services as $service)
                    <div class="panel-body">{{ $service }}</div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<div class="col-lg-8">
    <div class="row"><h2 class="text-center">{{ $brand->title }}</h2></div>
    <hr>
    <div class="row">{{ $brand->address }}</div>
    <h3>О нас</h3>
    <div class="row">{!! $brand->about !!}</div>
</div>
<hr>
@if(!empty($articles))
    <div class="container bg-warning">
        @foreach($articles as $article)
            <a href="{{ route('articles', $article->alias) }}">{{ $article->title }}</a>
        @endforeach
    </div>
@endif