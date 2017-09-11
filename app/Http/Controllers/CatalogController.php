<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\EstablishmentratioRepository;
use Fresh\Estet\Repositories\EstablishmentsRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\BlogsRepository;
use Fresh\Estet\Repositories\PremiumsRepository;
use Cache;
use DB;

class CatalogController extends MainController
{

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

        $this->content = Cache::remember('catalog-brand', 60, function () use ($prem_rep, $repository) {
            $prems_ids = $prem_rep->getPremIds('brand');

            $prems = $repository->getPrems($prems_ids);

            $brands = $repository->getWithoutPrems(['logo', 'title', 'content', 'alias', 'address'], true, ['category', 'brand'], $prems_ids);

            return view('catalog.brands')->with(['brands' => $brands, 'prems' => $prems])->render();
        });
        return $this->renderOutput();
    }
}
