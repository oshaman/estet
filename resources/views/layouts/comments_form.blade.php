<div class="section-form">
    <p class="add-comm">Добавить коментарий:</p>
    {!! Form::open(['url' => route('comments'),'class'=>'section-form-up','method'=>'post']) !!}
        <input type="email" name="email" class="section-input" placeholder="ваша почта">
        <input type="text" name="name" class="section-input" placeholder="имя">
        <textarea name="comment" cols="40" rows="3" class="section-form-text" placeholder="текст"></textarea>
        <div class="section-form-down">
            <div>
                <input readonly="" type="text" name="cod" class="section-form-test" placeholder="78535">
                <input type="text" name="prof" class="section-form-test">
            </div>
            <button class="but-section-form @if(session()->has('doc')) but-section-purpur @endif" type="button">отправить</button>
        </div>
        <p> <img src="../img/content/refresh.png" alt="">Обновить</p>
    {{ Form::hidden('comment_post_ID', $id) }}
    {{ Form::hidden('comment_parent', 0) }}
    {{ Form::hidden('comment_source', $source) }}
    {!! Form::close() !!}
</div>