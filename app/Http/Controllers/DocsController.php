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
            if ($article) {

                if (!empty($article->seo)) {
                    $article->seo = $this->a_rep->convertSeo($article->seo);
                }
                $article->created = $this->a_rep->convertDate($article->created_at);
                $article->load('category');
                $article->load('tags');

//            Last 2 publications
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['id', '<>', $article->id]);
                $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);

                $this->content = view('doc.article')->with(['article'=>$article, 'lasts'=>$lasts])->render();
                return $this->renderOutput();
            }
        }

        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'doctor']);

        $articles = $this->a_rep->getMain(['alias', 'title', 'category_id', 'id', 'created_at', 'content'], $where, ['image', 'category'], 3, ['created_at', 'desc']);

        $this->content = view('doc.content')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function category($cat)
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['category_id', $cat->id] );
        $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

        $this->content = view('doc.cat')->with(['articles' => $articles])->render();
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
