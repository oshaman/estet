@if ($menu)
    <a class="navbar-brand" href="{{ route('horoscope') }}"> Гороскоп</a>
    <ul class="nav navbar-nav">
        &nbsp;<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cтатьи<span class="caret"></span></a>
            {!! Menu::get('patientMenu')->asUl(array('class' => 'dropdown-menu')) !!}
        </li>
    </ul>
@endif