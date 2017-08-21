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
            {!! Form::checkbox('doctor', 'doctor', false, ['class' => 'optradio']) !!} Статьи для докторов<br>
            {!! Form::checkbox('blog', 'blog', false, ['class' => 'optradio']) !!} Блог<br>
        </div>
        <div class="col-lg-4">
            {!! Form::checkbox('patient', 'patient', false, ['class' => 'optradio']) !!} Статьи для читателей<br>
            {!! Form::checkbox('catalog', 'catalog', false, ['class' => 'optradio']) !!} Каталог<br>
        </div>
        <div class="col-lg-4">
            {!! Form::select('limit', ['20', '50', '100'], old('limit') ? : '') !!} Кол-во строк
        </div>
    </div>
    <div class="row bg-success">
        {!! Form::select('categories', [null => 'Категория'] + $cats ?? [], old('categories') ? : '') !!}  Категории статей
    </div>
    <hr>
    <div class="row">
        {!! Form::button('Найти', ['class' => 'btn btn-primary','type'=>'submit']) !!}
    </div>
{!! Form::close() !!}
</div>