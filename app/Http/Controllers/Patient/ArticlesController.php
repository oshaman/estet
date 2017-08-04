<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Http\Controllers\Controller;
use Menu;
use DB;
use Fresh\Estet\Repositories\ArticlesRepository;

use Fresh\Estet\Article;

class ArticlesController extends Controller
{
    protected $template = '\patient.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar_vars = false;
    protected $a_rep;

    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }

    public function index($article=null)
    {
        if ($article) {
            dd($article);
        }

        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);

        $articles = $this->a_rep->getMain(['alias', 'title', 'category_id', 'id', 'created_at', 'content'], $where, ['image', 'category'], 3, ['created_at', 'desc']);
//        dd($articles);

        $this->content = view('patient.content')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function show()
    {
        $this->content = 'ARTICLES';
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
