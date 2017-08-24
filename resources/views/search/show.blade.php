<h2>Поиск</h2>
<div class="row">
{!! Form::open(['url'=>route('search'), 'class'=>'form-horizontal', 'method'=>'get']) !!}
    <div class="row">
        {!! Form::text('value', old('value') ? : '' , ['placeholder'=>'введите ваш запрос...', 'id'=>'value', 'class'=>'form-control']) !!}
    </div>
    <h4>Результаты поиска <span class="label label-info">{{ $titles->total() }}</span></h4>
    <h3>Cовпадение   -----------------------------------------------------</h3>
    <div class="row bg-success">
        {!! Form::radio('coincidence', 'exact', true, ['class' => 'optradio']) !!} Точное совпадение
        {!! Form::radio('coincidence', 'all', false, ['class' => 'optradio']) !!} Все слова
        {!! Form::radio('coincidence', 'any', false, ['class' => 'optradio']) !!} Любое слово
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
@if(!empty($titles))
    <div class="row">
    @if($titles->lastPage() >1)
        <h4>Страница <span class="label label-primary">{{ $titles->currentPage() }}</span> из <span class="label label-info">{{ $titles->lastPage() }}</span></h4>
    @endif
    @foreach($titles as $title)
        <div class="row">
            <span class="label label-warning">{{ $loop->iteration }}</span> <a href="{{ $title->path ?? '#' }}" >{{ $title->title }}</a>
            <p>cоздано {{ $title->created }} года.</p>{{$title->view}}
            <hr>
        </div>
    @endforeach
    </div>
    <!--PAGINATION-->
    <div class="general-pagination group">
        @if(is_object($titles) && !empty($titles->lastPage()) && $titles->lastPage() > 1)
            <ul class="pagination">
                @if($titles->currentPage() !== 1)
                    <li><a href="{{ $titles->url(($titles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $titles->lastPage(); $i++)
                    @if($titles->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $titles->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($titles->currentPage() !== $titles->lastPage())
                    <li><a href="{{ $titles->url(($titles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>
        @endif
    </div>
    <!--PAGINATION-->
@endif