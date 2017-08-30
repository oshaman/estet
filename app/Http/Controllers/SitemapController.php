<?php

namespace Fresh\Estet\Http\Controllers;

use Cache;
use Fresh\Estet\Repositories\SitemapRepository;

class SitemapController extends MainController
{
    protected $repository;

    public function index()
    {
        $this->repository = new SitemapRepository();

        $this->content = Cache::store('file')->remember('sitemap_view', 24 * 59, function () {
            $p_articles = $this->repository->getPatientArticles();
            $d_articles = $this->repository->getDocsArticles();
            $categories = $this->repository->getCategories();
            $blogs = $this->repository->getBlogs();
            $blog_cats = $this->repository->getBlogCats();
            $docs = $this->repository->getDocs();
            $establishments = $this->repository->getEstablishments();
            $events = $this->repository->getEvents();
            $event_cats = $this->repository->getEventCats();

            $vars = [
                'cats' => $categories,
                'p_articles' => $p_articles,
                'd_articles' => $d_articles,
                'blogs' => $blogs,
                'blog_cats' => $blog_cats,
                'docs' => $docs,
                'establishments' => $establishments,
                'est_cats' => ['clinic', 'distributor', 'brand'],
                'events' => $events,
                'event_cats' => $event_cats,
            ];

            return view('sitemap.content')->with('vars', $vars)->render();
        });
        \Log::info('Карта сайта обновлена: ' . date("d-m-Y H:i"));
        return true;
    }

    /**
     * @return view
     */
    public function show()
    {
        $this->title = 'Sitemap';

        $this->index();

        return $this->renderOutput();
    }
}
