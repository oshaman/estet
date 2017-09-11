<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\EstablishmentratioRepository;
use Fresh\Estet\Repositories\EstablishmentsRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\BlogsRepository;
use Fresh\Estet\Repositories\PremiumsRepository;
use Fresh\Estet\Repositories\AdvertisingRepository;
use Fresh\Estet\Repositories\ArticlesRepository;
use Cache;
use DB;

class CatalogController extends MainController
{
    protected $nav;
    protected $prem_rep;
    protected $ratio_rep;
    protected $repository;

    public function __construct(
        ArticlesRepository $a_rep,
        AdvertisingRepository $adv,
        PremiumsRepository $prem_rep,
        EstablishmentratioRepository $ratio_rep,
        EstablishmentsRepository $repository
    )
    {
        parent::__construct($a_rep, $adv);
        Cache::flush();
        $this->css = '
            <link rel="stylesheet" type="text/css" href="' . asset('css') . '/katalog-brendu.css">
        ';

        $this->nav = Cache::remember('catalog-nav', 24*60, function () {
            return view('catalog.nav')->render();
        });

        $this->prem_rep = $prem_rep;
        $this->ratio_rep = $ratio_rep;
        $this->repository = $repository;
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
        if ($doc) {
            $this->content = Cache::remember('doc', 24 * 60, function () use ($doc, $blog_rep) {
                if (!empty($doc->services)) {
                    $doc->services = json_decode($doc->services);
                }

                if (!empty($doc->expirience)) {
                    $doc->expirience = date_create()->diff(date_create($doc->expirience))->y;
                }

                //  Blogs preview
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['user_id', $doc->user_id]);
                $blogs = $blog_rep->get(['alias', 'title', 'created_at'], 3, false, $where, ['created_at', 'desc'], ['blog_img', 'category'], true);

                return view('catalog.profiles.doc_profile')->with(['profile' => $doc, 'blogs' => $blogs])->render();
            });
            $this->title = $doc->name . ' ' . $doc->lastname;
            return $this->renderOutput();
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
    public function clinics($clinic = false)
    {
        $this->getSidebar(session()->has('doc'));
        if ($clinic) {

            $clinic = $this->repository->convertParams($clinic);
            $clinic->load('comments');

            $ratio = $this->ratio_rep->getRatio($clinic->id);
            $this->content = view('catalog.profiles.clinic')
                ->with(['clinic' => $clinic, 'nav' => $this->nav, 'ratio' => $ratio[0],
                    'sidebar' => $this->sidebar
                    ])
                ->render();

            return $this->renderOutput();
        }

        $this->title = 'Клиники';

        $this->content = Cache::remember('catalog-clinic', 60, function() {
            $prems_ids = $this->prem_rep->getPremIds('clinic');

            $prems = $this->repository->getPrems($prems_ids);

            $clinics = $this->repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'clinic'], $prems_ids);

            return view('catalog.clinics')->with(['clinics' => $clinics, 'prems' => $prems])->render();

        });

        return $this->renderOutput();
    }

    /**
     * @param alias $salon
     * @return view
     */
    public function distributors($distributor = false)
    {
        $this->getSidebar(session()->has('doc'));
        if ($distributor) {

            $distributor = $this->repository->convertParams($distributor);
            $distributor->load('comments');

            $children = $this->repository->getChildren($distributor->id);
            $ratio = $this->ratio_rep->getRatio($distributor->id);

            $this->content = view('catalog.profiles.distributor')
                ->with(['distributor' => $distributor, 'sidebar' => $this->sidebar, 'children' => $children,
                        'nav' => $this->nav, 'ratio' => $ratio[0]])
                ->render();

            return $this->renderOutput();
        }
        $this->title = 'Дистрибьюторы';

        $this->content = Cache::remember('catalog-distributor', 60, function () {
            $prems_ids = $this->prem_rep->getPremIds('distributor');

            $prems = $this->repository->getPrems($prems_ids);

            $distributors = $this->repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'distributor'], $prems_ids);

            return view('catalog.distributors')->with(['distributors' => $distributors, 'prems' => $prems])->render();
        });

        return $this->renderOutput();
    }

    /**
     * @param alias $brand
     * @return $this
     */
    public function brands($brand = false)
    {
        $this->getSidebar(session()->has('doc'));
        if ($brand) {
            $brand = $this->repository->convertParams($brand);
            $brand->load('comments');

            $parent = $this->repository->findById($brand->parent);

            $ratio = $this->ratio_rep->getRatio($brand->id);

            $this->content = view('catalog.profiles.brand')
                ->with(['brand' => $brand, 'parent' => $parent, 'sidebar' => $this->sidebar,
                    'nav' => $this->nav, 'ratio' => $ratio[0]])
                ->render();

            return $this->renderOutput();
        }

        $this->title = 'Бренды';

        $this->content = Cache::remember('catalog-brand', 60, function () {
            $prems_ids = $this->prem_rep->getPremIds('brand');

            $prems = $this->repository->getPrems($prems_ids);

            $brands = $this->repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'brand'], $prems_ids);

            return view('catalog.brands')->with(['brands' => $brands, 'prems' => $prems, 'sidebar' => $this->sidebar])->render();
        });
        return $this->renderOutput();
    }
}
