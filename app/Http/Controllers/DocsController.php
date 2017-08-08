<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Menu;
use DB;

class DocsController extends Controller
{
    protected $template = '\doc.index';
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

        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'doctor']);

        $articles = $this->a_rep->getMain(['alias', 'title', 'category_id', 'id', 'created_at', 'content'], $where, ['image', 'category'], 3, ['created_at', 'desc']);
//        dd($articles);


        $this->content = view('doc.content')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function category($cat)
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['category_id', $cat->id] );
        $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

        $this->content = view('patient.cat')->with(['articles' => $articles])->render();
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
        $cats = DB::select('SELECT `name`, `alias` FROM `docsmenuview`');
//        dd($cats);
        return Menu::make('docsMenu', function($menu) use ($cats) {

            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route'=>['docs_cat', $cat->alias]]);
            }

        });
    }
}
