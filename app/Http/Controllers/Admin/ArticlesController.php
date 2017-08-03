<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Gate;
use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Category;
use Fresh\Estet\Repositories\CategoriesRepository;
use Fresh\Estet\Tag;
use Fresh\Estet\Repositories\TagsRepository;
use Fresh\Estet\Http\Requests\Article as ArticleRequest;

class ArticlesController extends AdminController
{
    protected $a_rep;

    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }

    public function index()
    {
        if (Gate::denies('ADD_ARTICLES')) {
            abort(404);
        }
        $articles = $this->a_rep->get(['alias', 'title', 'created_at', 'id'], false, true, ['approved', 0]);
//        dd($articles);
        $this->content = view('admin.article.index')->with(['articles' => $articles])->render();

        return $this->renderOutput();
    }

    public function create(ArticleRequest $request)
    {
        if (Gate::denies('ADD_ARTICLES')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            dd($request->all());
        }

        $this->title = 'Добавление статьи';
        $this->template = 'admin.article.admin';
        //  get categories
        $cats = new CategoriesRepository(new Category);
        $lists = $cats->catSelect();
        //  get tags
        $tags = new TagsRepository(new Tag);
        $tag = $tags->tagSelect();

        $this->content = view('admin.article.add')->with(['cats' => $lists, 'tags'=>$tag])->render();

        return $this->renderOutput();
    }

    public function edit($id)
    {
        dd('EDIT');

    }

    public function del($id)
    {
        dd('DEL');
    }
}
