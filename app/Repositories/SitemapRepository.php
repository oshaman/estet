<?php
namespace Fresh\Estet\Repositories;

use Fresh\Estet\Menu;
use App;
use URL;
use Cache;
use DB;
use Fresh\Estet\Article;
use Fresh\Estet\Blog;

class SitemapRepository
{
    public function index()
    {
        // create new sitemap object
        $sitemap_article_docs = App::make("sitemap");
        $sitemap_article_patients = App::make("sitemap");

//    Articles
        $posts = Article::where('approved', 1)->with('image')->orderBy('updated_at', 'desc')->get();
        foreach ($posts as $post)
        {
            // get all images for the current post
            $images = array();

            $images[] = array(
                'url' => asset('\images\article\main\\').$post->image->path,
                'title' => $post->image->title,
                'caption' => $post->image->alt
            );

            if ('patient' == $post->own) {
                $sitemap_article_patients->add(URL::to('articles/' .$post->alias), $post->updated_at, '0.9', 'weekly', $images);
            } else {
                $sitemap_article_docs->add(URL::to('doctor/statyi/' .$post->alias), $post->updated_at, '0.9', 'weekly', $images);
            }
        }
        $sitemap_article_patients->store('xml','sitemap-articles-patient');
        $sitemap_article_docs->store('xml','sitemap-articles-docs');
//    Articles
//    Blogs
        $sitemap_blog = App::make("sitemap");
        $blogs = Blog::with('blog_img')->orderBy('created_at', 'desc')->get();
        foreach ($blogs as $blog)
        {
            // get all images for the current post
            $images = array();

            $images[] = array(
                'url' => asset('\images\blog\main\\').$blog->blog_img->path,
                'title' => $blog->blog_img->title,
                'caption' => $blog->blog_img->alt
            );

            $sitemap_blog->add(URL::to('doctor/blog/' .$blog->alias), $blog->updated_at, '0.9', 'weekly', $images);
        }
        $sitemap_blog->store('xml','sitemap-blog');
//    Blogs
//    Establishments
        $sitemap_establishment = App::make("sitemap");
        $establishments = DB::table('establishments')->orderBy('created_at', 'desc')->get();
        foreach ($establishments as $establishment)
        {
            switch ($establishment->category) {
                case 'clinic':
                    $images = array();

                    $images[] = array(
                        'url' => asset('\images\establishment\main\\').$establishment->logo,
                        'title' => $establishment->title,
                        'caption' => $establishment->title
                    );
                    $sitemap_establishment->add(URL::to('catalog/kliniki/' . $establishment->alias), $establishment->updated_at, '0.9', 'daily', $images);
                    break;
                case 'distributor':
                    $images = array();

                    $images[] = array(
                        'url' => asset('\images\establishment\main\\').$establishment->logo,
                        'title' => $establishment->title,
                        'caption' => $establishment->title
                    );
                    $sitemap_establishment->add(URL::to('catalog/distributory/' . $establishment->alias), $establishment->updated_at, '0.9', 'daily', $images);
                    break;
                case 'brand':
                    $images[] = array(
                        'url' => asset('\images\establishment\main\\').$establishment->logo,
                        'title' => $establishment->title,
                        'caption' => $establishment->title
                    );
                    $sitemap_establishment->add(URL::to('catalog/brendy/' . $establishment->alias), $establishment->updated_at, '0.9', 'daily', $images);
                    break;
            }
        }
        $sitemap_establishment->store('xml','sitemap-establishment');
//      Establishments
//      Docs
        $sitemap_doc = App::make("sitemap");

        $docs = DB::table('persons')->orderBy('created_at', 'desc')->get();
        foreach ($docs as $doc)
        {
            $images = array();

            $images[] = array(
                'url' => asset('estet\img\profile\\').$doc->photo,
                'title' => $doc->lastname,
                'caption' => $doc->name. ' ' .$doc->lastname
            );
            $sitemap_doc->add($doc->site, $doc->updated_at, '0.9', 'daily', $images);
        }
        $sitemap_doc->store('xml','sitemap-doc');
//      Docs
        $sitemap_main = App::make("sitemap");

        $sitemap_main->add(URL::to('/'), '2017-08-15T20:10:00+02:00', '1.0', 'daily');
        $sitemap_main->add(URL::to('goroscop'), '2012-08-16T12:30:00+02:00', '0.9', 'monthly');
        $sitemap_main->add(URL::to('doctor/blog'), '2012-08-16T12:30:00+02:00', '0.9', 'daily');
        $sitemap_main->add(URL::to('catalog/kliniki'), '2012-08-16T12:30:00+02:00', '0.9', 'daily');
        $sitemap_main->add(URL::to('catalog/brendy'), '2012-08-16T12:30:00+02:00', '0.9', 'daily');
        $sitemap_main->add(URL::to('catalog/distributory'), '2012-08-16T12:30:00+02:00', '0.9', 'daily');
        $sitemap_main->add(URL::to('catalog/vrachi'), '2012-08-16T12:30:00+02:00', '0.9', 'daily');

//        categories
        $cats = Menu::with('category')->get();

        foreach ($cats as $cat)
        {
            if ('docs' == $cat->own) {
                $sitemap_main->add(route('docs_cat', $cat->category->alias), $cat->category->updated_at, '0.5', 'weekly');
            } else {
                $sitemap_main->add(route('article_cat', $cat->category->alias), $cat->category->updated_at, '0.5', 'weekly');
            }
        }
//        categories
        $sitemap_main->store('xml','sitemap-main');

        $sitemap = App::make("sitemap");

        $sitemap->addSitemap(URL::to('sitemap-articles-patient.xml'));
        $sitemap->addSitemap(URL::to('sitemap-articles-docs.xml'));
        $sitemap->addSitemap(URL::to('sitemap-blog.xml'));
        $sitemap->addSitemap(URL::to('sitemap-establishment.xml'));
        $sitemap->addSitemap(URL::to('sitemap-doc.xml'));
        $sitemap->addSitemap(URL::to('sitemap-main.xml'));
//        dd($sitemap);
//        return $sitemap->render('sitemapindex', 'sitemap');
        \Log::info('Sitemap updated - '. date("d-m-Y H:i:s"));
        $sitemap->store('sitemapindex', 'sitemap');
    }

    public function getCategories()
    {
        return DB::select('SELECT * FROM `cats_view`');
    }

    public function getPatientArticles()
    {
        return Article::select('title', 'alias', 'category_id')->where([['approved', 1], ['own', 'patient']])->orderBy('updated_at', 'desc')->get();
    }

    public function getDocsArticles()
    {
        return Article::select('title', 'alias', 'category_id')->where([['approved', 1], ['own', 'docs']])->orderBy('updated_at', 'desc')->get();
    }
}
