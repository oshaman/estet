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


    public function index ()
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
    public function docs (PersonsRepository $rep, BlogsRepository $blog_rep, $doc = false)
    {
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

        $profiles = $rep->get(['name', 'address', 'phone', 'site', 'alias', 'photo'], false, true, false, false, 'specialties');

        $this->content = view('catalog.docs')->with(['title' => $this->title, 'profiles' => $profiles]);
        return $this->renderOutput();
    }

    /**
     * @param alias $clinic
     * @return view
     */
    public function clinics (EstablishmentratioRepository $ratio_rep, EstablishmentsRepository $repository, $clinic = false)
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

        $clinics = $repository->get(['logo', 'title', 'about', 'alias', 'address'], false, true, ['category','clinic']);

        $this->content = view('catalog.clinics')->with(['clinics' => $clinics])->render();
        return $this->renderOutput();
    }

    /**
     * @param alias $salon
     * @return view
     */
    public function distributors (EstablishmentsRepository $repository, $distributor = false)
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
        $distributors = $repository->get(['logo', 'title', 'about', 'alias', 'address'], false, true, ['category','distributor']);

        $this->content = view('catalog.distributors')->with(['distributors' => $distributors])->render();
        return $this->renderOutput();
    }

    /**
     * @param alias $brand
     * @return $this
     */
    public function brands (PremiumsRepository $prem_rep, EstablishmentsRepository $repository, $brand = false)
    {
        if ($brand) {
            $brand = $repository->convertParams($brand);
            $brand->load('comments');

            $parent = $repository->findById($brand->parent);

            $this->content = view('catalog.profiles.brand')->with(['brand' => $brand, 'parent' => $parent])->render();

            return $this->renderOutput();
        }
        
        $this->title = 'Бренды';
        $prems_ids = $prem_rep->getPremIds('brand');

        $prems = $repository->getPrems($prems_ids);

        $brands = $repository->get(['logo', 'title', 'about', 'alias', 'address'], false, true, ['category','brand']);

        $this->content = view('catalog.brands')->with(['brands' => $brands, 'prems' => $prems])->render();
        return $this->renderOutput();
    }

    public function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);

        $status = session('doc');

//        sidebar
        $own = $status ? 'docs' : 'patient';
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['own', $own]);

        $last_articles = $this->a_rep->getLast(['title', 'created_at', 'alias'], $where,2, ['created_at', 'desc']);

        $this->sidebar = view('catalog.sidebar')->with(['lasts' => $last_articles, 'status' =>$status])->render();
        $this->vars = array_add($this->vars, 'sidebar', $this->sidebar);
//        sidebar

        $menu = $this->getMenu($status);

        $this->vars = array_add($this->vars, 'nav', $menu);

        if(false !== $this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }

        return view($this->template)->with($this->vars);
    }

    public function getMenu($status)
    {
        $select =  $status ? 'docsmenuview' : 'patientmenuview';
        $cats = DB::select('SELECT `name`, `alias` FROM ' . $select);
        return $cats;

    }

}
