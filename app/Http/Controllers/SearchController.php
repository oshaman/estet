<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\SearchRepository;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    protected $title;
    protected $template = 'search.index';
    protected $content = false;
    protected $vars;
    protected $sidebar = false;
    protected $repository;

    public function __construct(SearchRepository $repository)
    {
        $this->repository = $repository;

    }


    public function show(Request $request)
    {
        if ($request->has('value')) {
            $result = $this->repository->get($request);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->back()->withErrors($result['error'])->withInput();
            }
            return redirect()->back()->with($result);
        }
        $this->content = view('search.show')->render();
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
        $own = $status ? 'docs' : 'patient';
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', $own]);

        $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

        $this->sidebar = view('catalog.sidebar')->with(['lasts' => $last_articles, 'status' => $status])->render();
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
        $select = $status ? 'docsmenuview' : 'patientmenuview';
        $cats = DB::select('SELECT `name`, `alias` FROM ' . $select);
        return $cats;

    }

}
