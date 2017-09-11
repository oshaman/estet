<h2>Редактирование страницы "{{ trans('ru.'.$page->own) }}"</h2>
<hr>
{!! Form::open(['url'=>route('static_update', $page->id), 'method'=>'post', 'class'=>'form-horizontal']) !!}
<div class="row">
    <div class="row">
        {{ Form::label('text', 'Заголовок') }}
        <div>
            {!! form::text('title', old('title') ? : ($page->title ?? '') , ['placeholder'=>'Заголовок', 'id'=>'title', 'class'=>'form-control']) !!}
        </div>
        {{ Form::label('text', 'Контент') }}
        <div>
            {!! Form::textarea('text', old('text') ? : ($page->text ?? '') , ['placeholder'=>'text', 'id'=>'text', 'class'=>'form-control editor']) !!}
        </div>
    </div>
    <!-- SEO -->
    <div class="panel-heading">
        <h2>
            <a data-toggle="collapse" href="#service" class="btn btn-info btn-block">SEO</a>
        </h2>
    </div>
    <div id="service" class="panel-collapse collapse row">
        <div class="row">
            <div class="col-lg-6">
                {{ Form::label('seo_title', 'SEO_TITLE') }}
                <div>
                    {!! Form::text('seo_title', old('seo_title') ? : ($page->seo->seo_title ?? '') , ['placeholder'=>'seo_title', 'id'=>'seo_title', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                {{ Form::label('seo_keywords', 'SEO_KEYWORDS') }}
                <div>
                    {!! Form::text('seo_keywords', old('seo_keywords') ? : ($page->seo->seo_keywords ?? '') , ['placeholder'=>'seo_keywords', 'id'=>'seo_keywords', 'class'=>'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {{ Form::label('seo_description', 'SEO_DESCRIPTION') }}
                <div>
                    {!! Form::text('seo_description', old('seo_description') ? : ($page->seo->seo_description ?? '') , ['placeholder'=>'seo_description', 'id'=>'seo_description', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                {{ Form::label('og_image', 'OG_IMAGE') }}
                <div>
                    {!! Form::text('og_image', old('og_image') ? : ($page->seo->og_image ?? '') , ['placeholder'=>'og_image', 'id'=>'og_image', 'class'=>'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                {{ Form::label('og_title', 'OG_TITLE') }}
                <div>
                    {!! Form::text('og_title', old('og_title') ? : ($page->seo->og_title ?? '') , ['placeholder'=>'og_title', 'id'=>'og_title', 'class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                {{ Form::label('og_description', 'OG_DESCRIPTION') }}
                <div>
                    {!! Form::text('og_description', old('og_description') ? : ($page->seo->og_description ?? '') , ['placeholder'=>'og_description', 'id'=>'og_description', 'class'=>'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            {{ Form::label('seo_text', 'SEO_TEXT') }}
            <div>
            <textarea name="seo_text" id="seo_text"
                      class="form-control">{!! old('seo_text') ? : ($page->seo->seo_text ?? '')  !!}
            </textarea>
            </div>
        </div>
    </div>
    <!-- SEO -->
</div>
<hr>
{!! Form::button('Сохранить', ['class' => 'btn btn-large btn-primary','type'=>'submit']) !!}
{!! Form::close() !!}