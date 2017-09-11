@if (!empty($profiles))
    @foreach($profiles as $profile)
        <div class="row">
            <div class="col-xs-8">
                <div class="row">
                    <h3>{{ ($profile->name ?? '') . ' ' . ($profile->lastname ?? '')}}</h3>
                    <hr>
                </div>
                <div class="row">
                    <h4>{{ $profile->specialties->implode('name', ', ') ?? ''}}</h4>
                    <hr>
                    @if(!empty($profile->address))
                        <h4>{{ $profile->address}}</h4>
                    @endif
                    @if(!empty($profile->job))
                        <h4>{{ $profile->job ?? ''}}</h4>
                    @endif
                    <h4>{{ $profile->phone ?? ''}}</h4>
                    <h4>{{ $profile->site ?? ''}}</h4>
                    <hr>
                </div>
            </div>
            <div class="col-xs-3">
                <img class="img-thumbnail" src="{{ asset(config('settings.theme'))  . '/img/profile/' . ($profile->photo ?? '../no_photo.jpg') }}">
            </div>
        </div>
        <div class="row">
            {!! Form::open(['url' => route('docs', $profile->alias), 'class'=>'form-horizontal', 'method'=>'GET']) !!}
            {!! Form::button('Подробнее о ' . trans('ru.doce'), ['class' => 'btn btn-primary','type'=>'submit']) !!}
            {!! Form::close() !!}
        </div>
    @endforeach

    <!--PAGINATION-->

    <div class="general-pagination group">

        @if($profiles->lastPage() > 1)
            <ul class="pagination">
                @if($profiles->currentPage() !== 1)
                    <li><a href="{{ $profiles->url(($profiles->currentPage() - 1)) }}">{{ Lang::get('pagination.previous') }}</a></li>
                @endif

                @for($i = 1; $i <= $profiles->lastPage(); $i++)
                    @if($profiles->currentPage() == $i)
                        <li><a class="selected disabled">{{ $i }}</a></li>
                    @else
                        <li><a href="{{ $profiles->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endfor

                @if($profiles->currentPage() !== $profiles->lastPage())
                    <li><a href="{{ $profiles->url(($profiles->currentPage() + 1)) }}">{{ Lang::get('pagination.next') }}</a></li>
                @endif
            </ul>

        @endif

    </div>
@endif