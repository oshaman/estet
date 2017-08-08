<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                    Меню пациентов</a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse in">
            <div class="panel-body">
                @if($cats)
                    {!! Form::open(['url'=>route('menus'), 'method'=>'post', 'class'=>'form-horizontal']) !!}
                    <ul class="list-group">
                        @foreach($cats as $cat)
                                    <li class="list-group-item">
                                        <input name="cats[]" type="checkbox"
                                            @foreach($menus as $menu)
                                                @if('docs' == $menu->own)
                                                    @continue
                                                @endif
                                                @if($menu->category_id === $cat->id)
                                                    checked
                                                    @break
                                                @endif
                                            @endforeach
                                            value="{{$cat->id}}">{{$cat->name}}
                                    </li>
                        @endforeach
                    </ul>
                    {!! Form::button('Сохранить', ['class'=>'btn btn-large btn-primary', 'type'=>'submit']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                    Меню врачей</a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
                @if($cats)
                    {!! Form::open(['url'=>route('menus'), 'method'=>'post', 'class'=>'form-horizontal']) !!}
                    <ul class="list-group">
                        @foreach($cats as $cat)
                            <li class="list-group-item">
                                <input name="docs_cats[]" type="checkbox"
                                       @foreach($menus as $menu)
                                           @if('docs' !== $menu->own)
                                               @continue
                                           @endif
                                           @if($menu->category_id === $cat->id)
                                               checked
                                               @break
                                           @endif
                                       @endforeach
                                       value="{{$cat->id}}">{{$cat->name}}
                            </li>
                        @endforeach
                    </ul>
                    {!! Form::button('Сохранить', ['class'=>'btn btn-large btn-primary', 'type'=>'submit']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
</div>