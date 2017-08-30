<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Fresh\Estet\Repositories\SitemapRepository;

class SitemapController extends MainController
{
    protected $repository;

    public function show()
    {
        $this->title = 'Sitemap';

        $this->repository = new SitemapRepository();

//        $this->content = Cache::store('file')->remember('sitemap_view', 24*60, function () {
//
//        });
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

//        dd($vars);
        $this->content = view('sitemap.content')->with('vars', $vars)->render();
        return $this->renderOutput();
    }
}
