<h2>Поиск</h2>
<div class="row">
{!! Form::open(['url'=>route('search'), 'class'=>'form-horizontal', 'method'=>'get']) !!}
    <div class="row">
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'введите ваш запрос...', 'id'=>'value', 'class'=>'form-control']) !!}
    </div>
    <h3>Cовпадение   -----------------------------------------------------</h3>
    <div class="row bg-success">
        {!! Form::radio('coincidence', 'all', true, ['class' => 'optradio']) !!} Все слова
        {!! Form::radio('coincidence', 'any', false, ['class' => 'optradio']) !!} Любое слово
        {!! Form::radio('coincidence', 'exact', false, ['class' => 'optradio']) !!} Точное совпадение
        {!! Form::select('order', ['Новые первыми', 'Старые первыми', 'По алфавиту', 'По популярности'], old('order') ? : '') !!} Порядок
    </div>
    <hr>
    <div class="row bg-success">
        <div class="col-lg-4">
            {!! Form::checkbox('comments', 'comments', false, ['class' => 'optradio']) !!} Коментарии<br>
            {!! Form::checkbox('categories', 'categories', false, ['class' => 'optradio']) !!} Категории<br>
            {!! Form::checkbox('contacts', 'contacts', false, ['class' => 'optradio']) !!} Контакты
        </div>
        <div class="col-lg-4">
            {!! Form::checkbox('materials', 'materials', false, ['class' => 'optradio']) !!} Материалы<br>
            {!! Form::checkbox('rss', 'rss', false, ['class' => 'optradio']) !!} Ленты новостей<br>
            {!! Form::checkbox('links', 'links', false, ['class' => 'optradio']) !!} Ссылки
        </div>
        <div class="col-lg-4">
            {!! Form::select('limit', ['20', '50', '100'], old('limit') ? : '') !!} Кол-во строк
        </div>

    </div>
    <hr>
    <div class="row">
        {!! Form::button('Найти', ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
{!! Form::close() !!}
</div>