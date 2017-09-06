<?php

namespace Fresh\Estet\Http\Controllers;

use Fresh\Estet\Repositories\ArticlesRepository;
use Fresh\Estet\Repositories\SeoRepository;
use Fresh\Estet\Repositories\Static_pageRepository;
use Cache;

class Static_pageController extends MainController
{
    protected $repository;
    protected $seo_rep;

    public function __construct(ArticlesRepository $a_rep, Static_pageRepository $repository, SeoRepository $seo_rep)
    {
        parent::__construct($a_rep);
        $this->repository = $repository;
        $this->seo_rep = $seo_rep;
    }

    public function contacts()
    {
        $this->content = Cache::remember('contacts', 24*60, function () {
            $contacts = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', 'contacts']);
            $contacts = $contacts->first();
            $contacts->seo = $this->repository->convertSeo($contacts->seo);
            return view('static_pages.contacts')->with('contacts', $contacts)->render();
        });

        return $this->renderOutput();
    }

    public function about()
    {
        $this->content = Cache::remember('about', 24*60, function () {
            $about = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', 'about']);
            $about = $about->first();
            $about->seo = $this->repository->convertSeo($about->seo);
            return view('static_pages.about')->with('about', $about)->render();
        });

        return $this->renderOutput();
    }
    
    public function advertising()
    {
        $this->content = Cache::remember('advertising', 24*60, function () {
            $advertising = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', 'advertising']);
            $advertising = $advertising->first();
            $advertising->seo = $this->repository->convertSeo($advertising->seo);
            return view('static_pages.advertising')->with('advertising', $advertising)->render();
        });

        return $this->renderOutput();
    }
    
    public function conditions()
    {
        $this->content = Cache::remember('conditions', 24*60, function () {
            $conditions = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', 'conditions']);
            $conditions = $conditions->first();
            $conditions->seo = $this->repository->convertSeo($conditions->seo);
            return view('static_pages.conditions')->with('conditions', $conditions)->render();
        });

        return $this->renderOutput();
    }
    
    public function partnership()
    {
        $this->content = Cache::remember('partnership', 24*60, function () {
            $partnership = $this->repository->get(['title', 'seo', 'text'], false, false, ['own', 'partnership']);
            $partnership = $partnership->first();
            $partnership->seo = $this->repository->convertSeo($partnership->seo);
            return view('static_pages.partnership')->with('partnership', $partnership)->render();
        });

        return $this->renderOutput();
    }
}
