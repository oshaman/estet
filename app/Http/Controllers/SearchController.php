<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\CategoriesRepository;
use Fresh\Estet\Repositories\SearchRepository;
use Illuminate\Http\Request;
use DB;
use Cache;
use Menu;

class SearchController extends MainController
{
    protected $repository;
    protected $cat_rep;

    /**
     * SearchController constructor.
     * @param SearchRepository $repository
     * @param ArticlesRepository $a_rep
     * @param CategoriesRepository $cat_rep
     */
    public function __construct(
        SearchRepository $repository,
        CategoriesRepository $cat_rep,
        ArticlesRepository $article
    )
    {
        parent::__construct($article);
        $this->repository = $repository;
        $this->cat_rep = $cat_rep;
    }

    /**
     * @param Request $request
     * @return $this|view
     */
    public function show(Request $request)
    {
        $cats = Cache::remember('allCats', 600, function () {
            return $this->cat_rep->catSelect();
        });

        if ($request->has('value')) {
            $result = $this->repository->get($request);

            if(is_array($result) && !empty($result['error'])) {
                return redirect()->route('search')->withErrors($result['error']);
            }
            if (is_object($result) && $result->isNotEmpty()) {
                $result->appends($request->all())->links();
            }
            $this->content = view('search.show')->with(['cats'=>$cats, 'titles'=>$result])->render();
            return $this->renderOutput();
        }

        $this->content = view('search.show')->with(['cats'=>$cats])->render();
        return $this->renderOutput();
    }
}
