<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\CategoriesRepository;
use Fresh\Estet\Repositories\SearchRepository;
use Illuminate\Http\Request;
use DB;
use Cache;

class SearchController extends Controller
{
    protected $title;
    protected $template = 'search.index';
    protected $content = false;
    protected $vars;
    protected $sidebar = false;
    protected $repository;
    protected $a_rep;
    protected $cat_rep;

    public function __construct(
        SearchRepository $repository,
        ArticlesRepository $a_rep,
        CategoriesRepository $cat_rep
)
    {
        $this->repository = $repository;
        $this->a_rep = $a_rep;
        $this->cat_rep = $cat_rep;

    }


    public function show(Request $request)
    {
        $cats = Cache::remember('allCats', 600, function () {
            return $this->cat_rep->catSelect();
        });

        if ($request->has('value')) {
            $result = $this->repository->get($request);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }
            return redirect()->back()->with($result);
        }

        $this->content = view('search.show')->with(['cats'=>$cats])->render();
        return $this->renderOutput();
    }

    /**
     * View Doctor's Profile
     * @param alias $doc
     * @return view
     */

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $status = session('doc');

//        sidebar

        $this->sidebar = Cache::remember('catalog_sidebar', 60, function () use ($status) {
            $own = $status ? 'docs' : 'patient';
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', $own]);
            $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

            //          most displayed
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', $own]);
            $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

            return view('catalog.sidebar')->with(['lasts' => $last_articles, 'status' => $status, 'articles' => $articles])->render();
        });

        $this->vars = array_add($this->vars, 'sidebar', $this->sidebar);
//        sidebar

        $menu = $this->getMenu($status);

        $this->vars = array_add($this->vars, 'nav', $menu);

        if (false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu($status)
    {
        if ($status) {
            $cats= Cache::remember('catalogMenu', 600, function () {
                return DB::select('SELECT `name`, `alias` FROM `docsmenuview`');
            });
        } else {
            return DB::select('SELECT `name`, `alias` FROM `patientmenuview`');
        }
        return $cats;

    }

}
