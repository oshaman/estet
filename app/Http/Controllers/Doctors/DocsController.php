<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Http\Controllers\Controller;
use Menu;
use DB;
use Cache;

class DocsController extends Controller
{
    protected $template = '\doc.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar = false;
    protected $a_rep;


    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }

    public function index($article=null)
    {
        if ($article) {

            if (!empty($article->seo)) {
                $article->seo = $this->a_rep->convertSeo($article->seo);
            }
            $article->created = $this->a_rep->convertDate($article->created_at);
            $article->load('category');
            $article->load('tags');
            $article->load('comments');

            $this->a_rep->displayed($article->id);
            $id = $article->id;
            $this->sidebar = Cache::remember('docsArticleSidebar', 60, function () use ($id) {
                //            Last 2 publications
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['id', '<>', $id]);
                $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);
                //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
                return view('doc.sidebar')->with(['lasts'=>$lasts, 'articles'=>$articles])->render();
            });


            $this->content = view('doc.article')->with(['article'=>$article, 'sidebar'=>$this->sidebar])->render();
            return $this->renderOutput();
        }

        $articles = Cache::remember('docsArticles', 60, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
            $select = ['alias', 'title', 'category_id', 'id', 'created_at', 'content'];
            return $this->a_rep->getMain($select, $where, ['image', 'category'], 3, ['created_at', 'desc']);
        });

        $this->content = view('doc.content')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function category($cat)
    {

        $this->content = Cache::remember('docs_cats', 60, function () use ($cat) {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['category_id', $cat->id] );
            $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

            return view('doc.cat')->with(['articles' => $articles])->render();
        });

        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $nav = Cache::remember('docsMenu', 60,function() {
            $menu = $this->getMenu();
            return view('layouts.nav')->with('menu', $menu)->render();
        });

        $this->vars = array_add($this->vars, 'nav', $nav);
        
        if($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {
        $cats = DB::select('SELECT `name`, `alias` FROM `docsmenuview`');

        return Menu::make('menu', function($menu) use ($cats) {

            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route'=>['docs_cat', $cat->alias]]);
            }
        });
    }

    /**
     * Select crticles by tag
     * @param $tag
     * @return view result
     */
    public function tag($tag)
    {
        $articles = $this->a_rep->getByTag($tag->id);
        $this->content = view('doc.tags')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }
}
