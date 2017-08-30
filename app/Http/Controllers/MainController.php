<?php

namespace Fresh\Estet\Http\Controllers;

use DB;
use Auth;
use Cache;
use Menu;
use Fresh\Estet\Repositories\ArticlesRepository;

class MainController extends Controller
{
    protected $template = 'main.index';
    protected $vars;
    protected $sidebar = false;
    protected $title;
    protected $a_rep;
    protected $content = false;

    /**
     * MainController constructor.
     * @param ArticlesRepository $a_rep
     */
    public function __construct(ArticlesRepository $a_rep)
    {
        $this->a_rep = $a_rep;
    }

    /**
     * View
     * @param alias $doc
     * @return view
     */

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $status = session('doc');

//        sidebar
        if ($status) {
            $this->sidebar = Cache::remember('docsSidebar', 60, function () {
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
                $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

                //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

                return view('main.sidebar')->with(['lasts' => $last_articles, 'status' => true, 'articles' => $articles])->render();
            });
        } else {
            $this->sidebar = Cache::remember('patientSidebar', 60, function () {
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
                $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

                //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

                return view('main.sidebar')->with(['lasts' => $last_articles, 'status' => false, 'articles' => $articles])->render();
            });
        }

        $this->vars = array_add($this->vars, 'sidebar', $this->sidebar);
//        sidebar

        if ($status) {
            $nav = Cache::remember('docsMenu', 600, function () use ($status) {
                $menu = $this->getMenu($status);
                return view('layouts.nav')->with('menu', $menu)->render();
            });
        } else {
            $nav = Cache::remember('patientMenu', 600, function () use ($status) {
                $menu = $this->getMenu($status);
                return view('layouts.nav')->with('menu', $menu)->render();
            });
        }

        $this->vars = array_add($this->vars, 'nav', $nav);

        if (false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    /**
     * @param $status boolean
     * @return mixed Menu Instance
     */
    public function getMenu($status)
    {
        $cats = DB::select('SELECT `name`, `alias` FROM ' . ($status ? 'docsmenuview' : 'patientmenuview'));

        return Menu::make('menu', function ($menu) use ($cats, $status) {
            $route = $status ? 'docs_cat' : 'article_cat';
            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route' => [$route, $cat->alias]]);
            }
        });
    }

}
