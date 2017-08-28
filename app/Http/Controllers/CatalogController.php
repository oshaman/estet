<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\EstablishmentratioRepository;
use Fresh\Estet\Repositories\EstablishmentsRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\BlogsRepository;
use DB;
use Fresh\Estet\Repositories\PremiumsRepository;
use Cache;
use Menu;

class CatalogController extends Controller
{
    protected $title;
    protected $template = 'catalog.index';
    protected $content = false;
    protected $vars;
    protected $sidebar = false;
    protected $a_rep;

    public function __construct(ArticlesRepository $repository)
    {
        $this->a_rep = $repository;
    }


    public function index()
    {
        abort(404);
//        $this->title = 'Каталог';
//        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * View Doctor's Profile
     * @param alias $doc
     * @return view
     */
    public function docs(PersonsRepository $rep, BlogsRepository $blog_rep, $doc = false)
    {
//        Cache::flush();
        if ($doc) {
            $docs = new PersonsRepository(new Person);
            $profile = $docs->one($doc);

            if (!empty($profile->services)) {
                $profile->services = json_decode($profile->services);
            }
            if (!$profile) {
                abort(404);
            }
            if (!empty($profile->expirience)) {
                $profile->expirience = date_create()->diff(date_create($profile->expirience))->y;
            }

            //  Blogs preview
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['user_id', $profile->user_id]);
            $blogs = $blog_rep->get(['alias', 'title', 'created_at'], 3, false, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);

            $this->title = $profile->name . ' ' . $profile->lastname;
            return view('catalog.profiles.doc_profile')->with(['profile' => $profile, 'blogs' => $blogs]);
        }
        $this->title = 'Врачи';

        $this->content = Cache::remember('catalog_doc', 60, function () use ($rep) {
            $profiles = $rep->get(['name', 'address', 'phone', 'site', 'alias', 'photo'], false, true, false, false, 'specialties');

            return view('catalog.docs')->with(['title' => $this->title, 'profiles' => $profiles])->render();
        });
        return $this->renderOutput();
    }

    /**
     * @param alias $clinic
     * @return view
     */
    public function clinics(PremiumsRepository $prem_rep, EstablishmentratioRepository $ratio_rep, EstablishmentsRepository $repository, $clinic = false)
    {
        if ($clinic) {

            /*$ua = $_SERVER['HTTP_USER_AGENT'];
            $ip = $_SERVER['REMOTE_ADDR'];

            $val = md5($ua . $ip);*/

            $clinic->load('articles');
            $clinic->load('comments');

            $ratio = $ratio_rep->getRatio($clinic->id);

            $clinic = $repository->convertParams($clinic);

            $this->content = view('catalog.profiles.clinic')->with(['clinic' => $clinic, 'ratio' => $ratio[0]])->render();

            return $this->renderOutput();
        }

        $this->title = 'Клиники';

        $this->content = Cache::remember('catalog-clinic', 60, function() use ($prem_rep, $repository) {
            $prems_ids = $prem_rep->getPremIds('clinic');

            $prems = $repository->getPrems($prems_ids);

            $clinics = $repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'clinic'], $prems_ids);

            return view('catalog.clinics')->with(['clinics' => $clinics, 'prems' => $prems])->render();

        });

        return $this->renderOutput();
    }

    /**
     * @param alias $salon
     * @return view
     */
    public function distributors(PremiumsRepository $prem_rep, EstablishmentsRepository $repository, $distributor = false)
    {
        if ($distributor) {

            $distributor->load('articles');
            $distributor->load('comments');

            $distributor = $repository->convertParams($distributor);

            $children = $repository->getChildren($distributor->id);

            $this->content = view('catalog.profiles.distributor')->with(['distributor' => $distributor, 'children' => $children])->render();

            return $this->renderOutput();
        }
        $this->title = 'Дистрибьюторы';

        $this->content = Cache::remember('catalog-distributor', 60, function () use ($prem_rep, $repository) {
            $prems_ids = $prem_rep->getPremIds('distributor');

            $prems = $repository->getPrems($prems_ids);

            $distributors = $repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'distributor'], $prems_ids);

            return view('catalog.distributors')->with(['distributors' => $distributors, 'prems' => $prems])->render();
        });

        return $this->renderOutput();
    }

    /**
     * @param alias $brand
     * @return $this
     */
    public function brands(PremiumsRepository $prem_rep, EstablishmentsRepository $repository, $brand = false)
    {
        if ($brand) {
            $brand = $repository->convertParams($brand);
            $brand->load('comments');

            $parent = $repository->findById($brand->parent);

            $this->content = view('catalog.profiles.brand')->with(['brand' => $brand, 'parent' => $parent])->render();

            return $this->renderOutput();
        }

        $this->title = 'Бренды';

        $this->content = Cache::remember('clinic-brand', 60, function() use ($prem_rep, $repository) {
            $prems_ids = $prem_rep->getPremIds('brand');

            $prems = $repository->getPrems($prems_ids);

            $brands = $repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'brand'], $prems_ids);

            return view('catalog.brands')->with(['brands' => $brands, 'prems' => $prems])->render();
        });
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $status = session('doc');

//        sidebar
        if ($status) {
            $this->sidebar = Cache::remember('catalog_sidebar_docs', 60, function () {
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
                $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

                //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'docs']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

                return view('catalog.sidebar')->with(['lasts' => $last_articles, 'status' => true, 'articles' => $articles])->render();
            });
        } else {
            $this->sidebar = Cache::remember('catalog_sidebar_patient', 60, function () {
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
                $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where, 2, ['created_at', 'desc']);

                //          most displayed
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', 'patient']);
                $articles = $this->a_rep->mostDisplayed(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

                return view('catalog.sidebar')->with(['lasts' => $last_articles, 'status' => false, 'articles' => $articles])->render();
            });
        }


        $this->vars = array_add($this->vars, 'sidebar', $this->sidebar);
//        sidebar

        if ($status) {
            $nav = Cache::remember('docsMenu', 600,function() use ($status) {
                $menu = $this->getMenu($status);
                return view('layouts.nav')->with('menu', $menu)->render();
            });
        } else {
            $nav = Cache::remember('patientMenu', 600,function() use ($status) {
                $menu = $this->getMenu($status);
                return view('layouts.nav')->with('menu', $menu)->render();
            });
        }

        $this->vars = array_add($this->vars, 'nav', $nav);

        if (false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu($status)
    {
        $cats = DB::select('SELECT `name`, `alias` FROM ' . ($status ? 'docsmenuview' : 'patientmenuview'));

        return Menu::make('menu', function($menu) use ($cats, $status) {
            $route = $status ? 'docs_cat' : 'article_cat';
            foreach ($cats as $cat) {
                $menu->add($cat->name, ['route'=>[$route, $cat->alias]]);
            }
        });
    }
}
