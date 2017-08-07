<?php

namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Http\Controllers\Controller;
use Fresh\Estet\Repositories\TagsRepository;
use Fresh\Estet\Tag;
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

    public function index()
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);

        $articles = $this->a_rep->getMain(['alias', 'title', 'category_id', 'id', 'created_at', 'content'], $where, ['image', 'category'], 3, ['created_at', 'desc']);

        $this->content = view('patient.content')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function show($article=null)
    {
        if ($article) {

            if (!empty($article->seo)) {
                $article->seo = $this->a_rep->convertSeo($article->seo);
            }
            $article->created = $this->a_rep->convertDate($article->created_at);
            $article->load('category');
            $article->load('tags');

//            Last 2 publications
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient'], ['id', '<>', $article->id]);
            $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);

            $this->content = view('patient.article')->with(['article'=>$article, 'lasts'=>$lasts])->render();
            return $this->renderOutput();
        }


        $this->content = 'ARTICLES';
        return $this->renderOutput();
    }

    /**
     * Select crticles by tag
     * @param $tag
     * @return view result
     */
    public function tag($tag)
    {
        $articles = $this->a_rep->getByTag($tag->id);
        $this->content = view('patient.tags')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function category($cat)
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient'], ['category_id', $cat->id] );;
        $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

        $this->content = view('patient.cat')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();

        $this->vars = array_add($this->vars, 'nav', $menu);

        if(false !== $this->content) {
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
