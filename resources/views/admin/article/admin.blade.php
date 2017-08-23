@extends('/../layouts/admin')

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
            images_upload_base_path: "{{asset('/photos')}}",
            automatic_uploads: true,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern",
                "importcss"
            ],
            content_css: "{{asset('css')}}/tinimce.css",
            importcss_append: true,
            importcss_file_filter: "{{asset('css')}}/tinimce.css",
            themes: "advanced",
            theme_advanced_styles: "Header 1=test",
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });
            }
        };

        tinymce.init(editor_config);
    </script>
@endsection

@section('navbar')
    @if ($nav)
        <div class="navbar-header">
            {!! Menu::get('adminMenu')->asUl(array('class' => 'nav nav-pills')) !!}
        </div>
    @endif
@endsection

@section('content')
    {!! $content !!}
@endsection