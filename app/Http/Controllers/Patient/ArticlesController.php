<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;
use Menu;

use Fresh\Estet\Article;

class ArticlesController extends Controller
{
    protected $template = '\patient.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar_vars = false;


    public function index($article=null)
    {
        if ($article) {
            dd($article);
        }

        $articles = Article::all();

        $articles->load('category');
        $articles->load('image');
        $articles->load('tags');
//        dd($articles);

        $this->content = view('patient.content')->with(['articles' => $articles])->render();
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
