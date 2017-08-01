<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use Menu;

class DocsController extends Controller
{
    protected $template = '\doc.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar_vars = false;


    public function index()
    {

        $this->content = view('doc.content')->render();
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $this->vars = array_add($this->vars, 'nav', $menu);

        if($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {
        return Menu::make('docsMenu', function($menu) {

            $menu->add(trans('ru.home'),  array('route'  => 'main'));

            $menu->add(trans('ru.blog'),  array('route'  => 'blogs'));
        });
    }
}
