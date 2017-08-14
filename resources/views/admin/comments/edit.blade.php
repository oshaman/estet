<h3>Модерация коментария</h3>
@if($comment)
<div class="row">
    {!! Form::open(['url' => route('edit_comment', $comment->id), 'class'=>'form-horizontal','method'=>'post' ]) !!}
    {!! Form::text('email', old('email') ? : ($comment->email ?? '') , ['placeholder'=>'Ваша почта', 'id'=>'email', 'class'=>'form-control']) !!}
    {!! Form::text('name', old('name') ? : ($comment->name ?? '') , ['placeholder'=>'Имя', 'id'=>'name', 'class'=>'form-control']) !!}
    {!! Form::textarea('text', old('text') ? : ($comment->text ?? '') , ['placeholder'=>'Коментарий', 'id'=>'text', 'class'=>'form-control', 'rows'=>5, 'cols'=>50]) !!}
    <div class="row">
        <!-- Approved -->
        <label><input type="checkbox" {{ (old('confirmed') || $comment->approved) ? 'checked' : ''}} value="1" name="confirmed"> Утвердить</label>
    </div>
    {{ Form::hidden('comment_post_ID', $comment->article_id ?? ($comment->blog_id ?? ($comment->establishment_id ?? ''))) }}
    {{ Form::hidden('comment_parent', $comment->parent_id) }}
    {{ Form::hidden('comment_source', $comment->source) }}
    <hr>
    {!! Form::button(trans('admin.sent'), ['class' => 'btn btn-success','type'=>'submit']) !!}
    {!! Form::close() !!}
</div>
@endif