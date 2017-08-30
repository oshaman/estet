<?php
namespace Fresh\Estet\Http\Controllers\Patient;

use Fresh\Estet\Http\Controllers\Controller;
use Menu;
use DB;
use Cache;
use Fresh\Estet\Repositories\ArticlesRepository;


class ArticlesController extends Controller
{
    protected $template = '\patient.index';
    protected $content = FALSE;
    protected $title;
    protected $vars;
    protected $sidebar = false;
    protected $a_rep;

    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }

    public function index()
    {
        $this->content = Cache::remember('main', 60, function() {

            $articles = [
                'lasts' => $this->a_rep->getMain([['id', '<>', null]],3, ['created_at', 'desc'], 'patient'),
                'popular' => $this->a_rep->getMain([['id', '<>', null]],4, ['view', 'desc'], 'patient'),
                'video' => $this->a_rep->getMain([['category_id', 20]],3, ['created_at', 'desc'], 'patient'),
                'facts' => $this->a_rep->getMain([['category_id', 17]],3, ['created_at', 'desc'], 'patient'),
                'diet' => $this->a_rep->getMain([['category_id', 19]],4, ['created_at', 'desc'], 'patient'),
                'beauty' => $this->a_rep->getMain([['category_id', 14]],3, ['created_at', 'desc'], 'patient'),
                'medicine' => $this->a_rep->getMain([['category_id', 15]],4, ['created_at', 'desc'], 'patient'),
                'advice' => $this->a_rep->getMain([['category_id', 16]],3, ['created_at', 'desc'], 'patient'),
                'stomatology' => $this->a_rep->getMain([['category_id', 8]],4, ['created_at', 'desc'], 'patient'),
                'psychology' => $this->a_rep->getMain([['category_id', 18]],3, ['created_at', 'desc'], 'patient'),
            ];
            return view('patient.content')->with(['articles' => $articles])->render();

        });
        return $this->renderOutput();
    }

    public function show($article=null)
    {
        if ($article) {

            $article_id = $article->id;
            $this->a_rep->displayed($article);

            $article = Cache::remember('patients_article-'.$article->id, 60, function () use ($article) {
                if (!empty($article->seo)) {
                    $article->seo = $this->a_rep->convertSeo($article->seo);
                }
                $article->created = $this->a_rep->convertDate($article->created_at);
                $article->load('category');
                $article->load('tags');
                return $article;
            });

            $this->sidebar = Cache::remember('patientSidebar', 60, function () use ($article_id) {
//                Last 2 publications
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient'], ['id', '<>', $article_id]);
                $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);

    //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
                return view('patient.sidebar')->with(['lasts'=>$lasts, 'articles'=>$articles])->render();
            });

            $this->content = view('patient.article')->with(['article'=>$article, 'sidebar'=>$this->sidebar])->render();
            return $this->renderOutput();
        }
        return redirect()->route('main');
    }

    /**
     * Select crticles by tag
     * @param $tag
     * @return view result
     */
    public function tag($tag)
    {
        $articles = $this->a_rep->getByTag($tag->id, 'patient');
        $this->content = view('patient.tags')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    /**
     * @param $cat
     * @return $this
     */
    public function category($cat)
    {
        $this->content = Cache::remember('articles_cats'.$cat->alias, 60, function () use ($cat) {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient'], ['category_id', $cat->id] );
            $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

            return view('patient.cat')->with(['articles' => $articles])->render();
        });

        return $this->renderOutput();
    }

    /**
     * @return $this
     */
    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $nav = Cache::remember('patientMenu', 60,function() {
            $menu = $this->getMenu();
            return view('layouts.nav')->with('menu', $menu)->render();
        });

        $this->vars = array_add($this->vars, 'nav', $nav);

        if(false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    /**
     * @return mixed
     */
    public function getMenu() {
        $cats = DB::select('SELECT `name`, `alias` FROM `patientmenuview`');

        return Menu::make('menu', function($menu) use ($cats) {
            $menu->add('Последние', ['route'=>['articles_last']]);
            foreach ($cats as $cat) {
                if ('Видео' == $cat->name) {
                    continue;
                }
                $menu->add($cat->name, ['route'=>['article_cat', $cat->alias]]);
            }

        });
    }

    /**
     * @return ArticlesController
     */
    public function lastArticles()
    {
        $this->content = Cache::remember('articles_last', 60, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
            $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

            return view('patient.cat')->with(['articles' => $articles])->render();
        });

        return $this->renderOutput();
    }
}
