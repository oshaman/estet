<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\AdvertisingRepository;
use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\SeoRepository;
use Fresh\Estet\Repositories\Static_pageRepository;
use Cache;

class Static_pageController extends MainController
{
    protected $repository;
    protected $seo_rep;

    public function __construct(
        ArticlesRepository $a_rep,
        Static_pageRepository $repository,
        SeoRepository $seo_rep,
        AdvertisingRepository $adv
    )
    {
        parent::__construct($a_rep, $adv);
        $this->repository = $repository;
        $this->seo_rep = $seo_rep;
    }

    public function contacts()
    {
        $name = 'contacts';
        return $this->cacheHandler($name);
    }

    public function about()
    {
        $name = 'about';
        return $this->cacheHandler($name);
    }
    
    public function advertising()
    {
        $name = 'advertising';
        return $this->cacheHandler($name);
    }
    
    public function conditions()
    {
        $name = 'conditions';
        return $this->cacheHandler($name);
    }
    
    public function partnership()
    {
        $name = 'partnership';
        return $this->cacheHandler($name);
    }


    public function getFooter($name)
    {
        $this->footer = Cache::remember('footer-' . $name, 24 * 60, function () {
            return view('layouts.footer')->render();
        });
    }

    /**
     * @param $name
     * @return view
     */
    public function cacheHandler($name)
    {
        $this->content = Cache::remember($name, 24 * 60, function () use ($name) {
            $model = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', $name]);
            $model = $model->first();
            $model->seo = $this->repository->convertSeo($model->seo);
            return view('static_pages.' . $name)->with($name, $model)->render();
        });
        $this->getFooter($name);
        return $this->renderOutput();
    }
}
