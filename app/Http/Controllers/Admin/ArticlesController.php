<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Gate;
use Fresh\Estet\Article;
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

    public function index(ArticleRequest $request)
    {
        if (Gate::denies('ADD_ARTICLES')) {
            abort(404);
        }

        $data = $request->except('_token');
        if (!empty($data['param'])) {
            $data['value'] = $data['value'] ?? null;
            switch ($data['param']) {
                case 1:
                    $articles[] = $this->a_rep->one($data['value']);
                    break;
                case 2:
                    $articles = $this->a_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['title', $data['value']]);
                    break;
                case 3:
                    $articles = $this->a_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0], ['created_at', 'desc']);
                    if ($articles) $articles->appends(['param' => $data['param']])->links();
                    break;
                case 4:
                    $articles = $this->a_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['own', 'doctor'], ['created_at', 'desc']);
                    if ($articles) $articles->appends(['param' => $data['param']])->links();
                    break;
                case 5:
                    $articles = $this->a_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['own', 'patient'], ['created_at', 'desc']);
                    if ($articles) $articles->appends(['param' => $data['param']])->links();
                    break;
                default:
                    $articles = $this->a_rep->get(['alias', 'title', 'created_at', 'id'], false, true, ['approved', 0], ['created_at', 'desc']);
                    if ($articles) $articles->appends(['param' => $data['param']])->links();
            }
        } else {
            $articles = $this->a_rep->get(['alias', 'title', 'created_at', 'id'], false, true, ['approved', 0], ['created_at', 'desc']);
        }

        $this->content = view('admin.article.index')->with(['articles' => $articles])->render();

        return $this->renderOutput();
    }

    public function create(ArticleRequest $request)
    {
        if (Gate::denies('ADD_ARTICLES')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'alias' => 'required|unique:articles,alias|max:255|alpha_dash',
            ]);
            $result = $this->a_rep->addArticle($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('admin_articles')->with($result);
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

    public function edit(ArticleRequest $request, $article)
    {
        if (Gate::denies('UPDATE_ARTICLES')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $result = $this->a_rep->updateArticle($request, $article);

            if(is_array($result) && !empty($result['error'])) {
                return back()->withErrors($result);
            }
            return redirect()->route('admin_articles')->with($result);
        }

        $this->title = 'Редактирование статьи';
        $this->template = 'admin.article.admin';
        //  get categories
        $cats = new CategoriesRepository(new Category);
        $lists = $cats->catSelect();
        //  get tags
        $tags = new TagsRepository(new Tag);
        $tag = $tags->tagSelect();

        $img = $article->image;
        $article->seo = $this->a_rep->convertSeo($article->seo);

        $this->content = view('admin.article.edit')->with(['article'=>$article, 'cats' => $lists, 'tags'=>$tag, 'img'=>$img])->render();

        return $this->renderOutput();

    }

    public function del(Article $article)
    {
        if (Gate::denies('DELETE_ARTICLES')) {
            abort(404);
        }

        $result = $this->a_rep->deleteArticle($article);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin_articles')->with($result);
    }
}
