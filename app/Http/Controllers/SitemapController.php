<?php

namespace Fresh\Estet\Http\Controllers;

use Cache;
use Fresh\Estet\Repositories\SitemapRepository;

class SitemapController extends MainController
{
    protected $repository;

    /**
     * @return bool
     */
    public function index()
    {
        $this->repository = new SitemapRepository();

        $this->content = Cache::store('file')->remember('sitemap_view', 1430, function () {
            $vars = [
                'cats' => $this->repository->getCategories(),
                'p_articles' => $this->repository->getPatientArticles(),
                'd_articles' => $this->repository->getDocsArticles(),
                'blogs' => $this->repository->getBlogs(),
                'blog_cats' => $this->repository->getBlogCats(),
                'docs' => $this->repository->getDocs(),
                'establishments' => $this->repository->getEstablishments(),
                'est_cats' => ['clinic', 'distributor', 'brand'],
                'events' => $this->repository->getEvents(),
                'event_cats' => $this->repository->getEventCats(),
            ];
            \Log::info('Карта сайта обновлена: ' . date("d-m-Y H:i"));
            return view('sitemap.content')->with('vars', $vars)->render();
        });
        return true;
    }

    /**
     * @return view
     */
    public function show()
    {
        $this->title = 'Sitemap';

        $this->index();
        $this->footer = Cache::remember('footer-sitemap', 24 * 60, function () {
            return view('layouts.footer')->render();
        });

        return $this->renderOutput();
    }
}
