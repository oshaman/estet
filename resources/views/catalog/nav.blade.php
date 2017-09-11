<div class="blog-section">
    <div class="categories-section @if('brands' == Route::currentRouteName()) active @endif"  >
        <a href="{{ route('brands') }}">
            <img src="{{ asset('estet') }}/img/blog/7.png" alt="">
            <span>Бренды</span>
        </a>
    </div>
    <div class="categories-section @if('clinics' == Route::currentRouteName()) active @endif">
        <a href="{{ route('clinics') }}">
            <img src="{{ asset('estet') }}/img/blog/7.png" alt="">
            <span>Клиники</span>
        </a>
    </div>
    <div class="categories-section @if('distributors' == Route::currentRouteName()) active @endif">
        <a href="{{ route('distributors') }}">
            <img src="{{ asset('estet') }}/img/blog/7.png" alt="">
            <span>Дистрибьюторы</span>
        </a>
    </div>
    <div class="categories-section @if('docs' == Route::currentRouteName()) active @endif">
        <a href="{{ route('docs') }}">
            <img src="{{ asset('estet') }}/img/blog/7.png" alt="">
            <span>Врачи</span>
        </a>
    </div>
</div>