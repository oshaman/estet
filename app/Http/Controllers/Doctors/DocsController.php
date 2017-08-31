<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Http\Controllers\Controller;
use Fresh\Estet\Repositories\EventsRepository;
use Fresh\Estet\Event;
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

    /**
     * DocsController constructor.
     * @param ArticlesRepository $repository
     */
    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }

    /**
     * @param null $article
     * @return DocsController
     */
    public function index($article = null)
    {
        if ($article) {

            $article = Cache::remember('docs_article-' . $article->id, 60, function () use ($article) {
                if (!empty($article->seo)) {
                    $article->seo = $this->a_rep->convertSeo($article->seo);
                }
                $article->created = $this->a_rep->convertDate($article->created_at);
                $article->load('category');
                $article->load('tags');
                $article->load('comments');
                return $article;
            });

            $this->a_rep->displayed($article);

            $this->content = view('doc.article')->with(['article' => $article])->render();
            $this->getSidebar();
            return $this->renderOutput();
        }
        $this->content = Cache::remember('docsArticles', 60, function () {
            $events = new EventsRepository(new Event());
            $articles = [
                'lasts' => $this->a_rep->getMain([['id', '<>', null]],4, ['created_at', 'desc'], 'docs'),
                'popular' => $this->a_rep->getMain([['id', '<>', null]],4, ['view', 'desc'], 'docs'),
                'video' => $this->a_rep->getMain([['category_id', 20]],3, ['created_at', 'desc'], 'docs'),
                'experts' => $this->a_rep->getMain([['category_id', 2]],3, ['created_at', 'desc'], 'docs'),
                'cosmetology' => $this->a_rep->getMain([['category_id', 5]],4, ['created_at', 'desc'], 'docs'),
                'dermatology' => $this->a_rep->getMain([['category_id', 4]],4, ['created_at', 'desc'], 'docs'),
                'practic' => $this->a_rep->getMain([['category_id', 1]],3, ['created_at', 'desc'], 'docs'),
                'plastic' => $this->a_rep->getMain([['category_id', 6]],4, ['created_at', 'desc'], 'docs'),
                'endocrinology' => $this->a_rep->getMain([['category_id', 12]],3, ['created_at', 'desc'], 'docs'),
                'stomatology' => $this->a_rep->getMain([['category_id', 8]],4, ['created_at', 'desc'], 'docs'),
                'venerology' => $this->a_rep->getMain([['category_id', 9]],3, ['created_at', 'desc'], 'docs'),
                'urology' => $this->a_rep->getMain([['category_id', 11]],3, ['created_at', 'desc'], 'docs'),
                'trihology' => $this->a_rep->getMain([['category_id', 7]],3, ['created_at', 'desc'], 'docs'),
                'events' => $events->get(['id', 'alias', 'title', 'created_at', 'view'], 3, false, [['approved',1]], ['created_at', 'desc'], ['logo']),
            ];
            return view('doc.content')->with(['articles' => $articles])->render();
        });

        return $this->renderOutput();
    }

    /**
     * @param $cat
     * @return DocsController
     */
    public function category($cat)
    {
        $this->content = Cache::remember('docs_cats'.$cat->alias, 60, function () use ($cat) {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs'], ['category_id', $cat->id]);
            $articles = $this->a_rep->get('*', 14, true, $where, ['created_at', 'desc'], ['image']);

            return view('doc.cat')->with(['articles' => $articles])->render();
        });
        $this->getSidebar();
        return $this->renderOutput();
    }

    /**
     * @return $this
     */
    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $nav = Cache::remember('docsMenu', 60, function () {
            $menu = $this->getMenu();
            return view('layouts.nav')->with('menu', $menu)->render();
        });

        $this->vars = array_add($this->vars, 'nav', $nav);

        if (false !== $this->sidebar) {
            $this->vars = array_add($this->vars, 'sidebar', $this->sidebar);
        }

        if ($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    /**
     * @return mixed
     */
    public function getMenu()
    {
        $cats = DB::select('SELECT `name`, `alias` FROM `docsmenuview`');

        return Menu::make('menu', function ($menu) use ($cats) {
            $menu->add('Последние', ['route' => ['docs_articles_last']]);
            foreach ($cats as $cat) {
                if ('Видео' == $cat->name) {
                    continue;
                }
                $menu->add($cat->name, ['route' => ['docs_cat', $cat->alias]]);
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
        $this->content = Cache::remember('docs_tags' . $tag->alias, 60, function () use ($tag) {
            $articles = $this->a_rep->getByTag($tag->id, 'docs');
            return view('doc.tags')->with(['articles' => $articles])->render();
        });

        $this->getSidebar();
        return $this->renderOutput();
    }

    /**
     * @return ArticlesController
     */
    public function lastArticles()
    {
        $this->content = Cache::remember('articles_last', 60, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
            $articles = $this->a_rep->get(['title', 'alias'], false, true, $where);

            return view('doc.cat')->with(['articles' => $articles])->render();
        });

        return $this->renderOutput();
    }

    /**
     * @return bool
     */
    public function getSidebar()
    {
        $this->sidebar = Cache::remember('docsArticleSidebar', 60, function () {
            //            Last 2 publications
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
            $lasts = $this->a_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['created_at', 'desc']);
            //          most displayed
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
            $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);
            return view('doc.sidebar')->with(['lasts' => $lasts, 'articles' => $articles])->render();
        });
        return true;
    }
}
