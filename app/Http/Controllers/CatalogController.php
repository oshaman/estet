<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\EstablishmentsRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\BlogsRepository;
use DB;

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
        $this->title = 'Каталог';
        return view('catalog.index')->with('title', $this->title);
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
            return view('catalog.doc_profile')->with(['profile' => $profile, 'blogs' => $blogs]);
        }
        $this->title = 'Врачи';

        $profiles = $rep->get(['name', 'address', 'phone', 'site', 'alias', 'photo'], false, true, false, false, 'specialties');

        return view('catalog.docs')->with(['title' => $this->title, 'profiles' => $profiles]);
    }

    /**
     * @param alias $clinic
     * @return view
     */
    public function clinics (EstablishmentsRepository $repository, $clinic = false)
    {
        if ($clinic) {
            dd($clinic);
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
    public function distributors ($distributor = false)
    {
        $this->title = 'Дистрибьюторы';
        return view('catalog.index')->with('title', $this->title);
    }

    /**
     * @param alias $brand
     * @return $this
     */
    public function brands ($brand = false)
    {
        $this->title = 'Бренды';
        return view('catalog.index')->with('title', $this->title);
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


//        $this->template = $status ? '\doc.index' : '\patient.index';
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
