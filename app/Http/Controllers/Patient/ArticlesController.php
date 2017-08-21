<?php
namespace Fresh\Estet\Http\Controllers\Patient;

use function foo\func;
use Fresh\Estet\Article;
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
//        dd(Cache::get('sub_doc'));
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
            $this->a_rep->displayed($article->id);
            $article_id = $article->id;
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
        $articles = $this->a_rep->getByTag($tag->id);
        $this->content = view('patient.tags')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function category($cat)
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient'], ['category_id', $cat->id] );
        $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

        $this->content = view('patient.cat')->with(['articles' => $articles])->render();
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $nav = Cache::remember('patientMenu', 60,function() {
            $menu = $this->getMenu();
            return view('patient.nav')->with('menu', $menu)->render();
        });

        $this->vars = array_add($this->vars, 'nav', $nav);

        if(false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {
        $cats = DB::select('SELECT `name`, `alias` FROM `patientmenuview`');

        return Menu::make('patientMenu', function($menu) use ($cats) {

            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route'=>['article_cat', $cat->alias]]);
            }

        });
    }
}
