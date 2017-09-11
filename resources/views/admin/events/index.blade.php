@extends('admin.index')

@section('tiny')
    <script src="{{ asset('/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        var editor_config = {
            path_absolute : "/",
            selector: "textarea.editor",
            language: 'ru',
            branding: false,
            height : 650,
            width : 960,
            plugins: [
                "advlist autolink lists link charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern",
                "importcss"
            ],
            content_css: "{{asset('css')}}/tinimce.css",
            importcss_file_filter: "{{asset('css')}}/app.css",
            importcss_append: true,
            style_formats: [
                {
                    title: 'Шаблоны', items: [
                    {title: 'Тест1', block: 'div', classes: 'left', exact: true, wrapper: 1},
                    {title: 'Две картинки', block: 'div', classes: 'two_pics', exact: true, wrapper: 1},
                ]
                },
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            relative_urls: false,
        };

        tinymce.init(editor_config);
    </script>
@endsection

@section('content')
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('eventcats_admin') }}">Категории</a></li>
                <li><a href="{{ route('organizers_admin') }}">Организаторы</a></li>
                <li><a href="{{ route('create_event') }}">Создание мероприятия</a></li>
            </ul>
        </div>
    </nav>
    <div class="col-lg-9">
        {!!  $content !!}
    </div>
@endsection