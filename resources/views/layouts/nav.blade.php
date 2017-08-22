@if ($menu)
    @if(!session()->has('doc'))
        <a class="navbar-brand" href="{{ route('horoscope') }}"> Гороскоп</a>
    @else
        <a class="navbar-brand" href="{{ route('events') }}"> Мероприятия</a>
        <a class="navbar-brand" href="{{ route('blogs') }}"> Блог</a>
    @endif
    <ul class="nav navbar-nav">
        &nbsp;<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cтатьи<span class="caret"></span></a>
            {!! Menu::get('menu')->asUl(array('class' => 'dropdown-menu')) !!}
        </li>
    </ul>
@endif