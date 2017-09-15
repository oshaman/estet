<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Event;
use Fresh\Estet\Repositories\AdvertisingRepository;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\Repositories\BlogsRepository;
use DB;
use Cache;
use Fresh\Estet\Repositories\EventsRepository;
use Fresh\Estet\Repositories\TagsRepository;

class BlogsController extends DocsController
{
    protected $blog_rep;
    protected $cat_rep;
    protected $tag_rep;
    protected $adv_rep;

    public function __construct(BlogsRepository $rep, BlogCategoriesRepository $cat_rep, TagsRepository $tags, AdvertisingRepository $adv_rep)
    {
        $this->css = '
                <link rel="stylesheet" type="text/css" href="' . asset('css') . '/blog.css">
                <link rel="stylesheet" type="text/css" href="' . asset('css') . '/blog-vnutrennyaya.css">
            ';
        $this->blog_rep = $rep;
        $this->tag_rep = $tags;
        $this->cat_rep = $cat_rep;
        $this->adv_rep = $adv_rep;
    }

    /**
     * @param  $blog_alias
     * @return $this
     */
    public function index($blog_alias=false)
    {
        $this->sidebar = $this->getSidebar();

        if ($blog_alias) {

            $blog = Cache::remember('blog-' . $blog_alias, 24 * 60, function () use ($blog_alias) {
                $blog = $this->blog_rep->one($blog_alias, true);
                if ($blog) {
                    $blog->load('comments');
                }

                return $blog;
            });

            if (!$blog) {
                abort(404);
            }
            $this->blog_rep->displayed($blog->id);


            $this->content = Cache::remember('blogs-preview-'.$blog_alias, 10, function () use ($blog) {


                //  Blogs preview
                $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['user_id', $blog->user_id], ['id', '!=', $blog->id]);
                $blogs = $this->blog_rep->get(['alias', 'title', 'created_at'], 3, false, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);
                //  If not enough author's blogs, attach blogs from the same category
                if (empty($blogs) || ($blogs->count() < 3)) {
                    if (empty($blogs)) {
                        $take = 3;
                    } else {
                        $take = 3 - $blogs->count();
                    }
                    $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', $blog->category_id], ['user_id', '<>', $blog->user_id]);
                    $by_cat = $this->blog_rep->get(['alias', 'title', 'created_at'], $take, false, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);

                    if ($by_cat) {
                        if (empty($blogs)) {
                            $blogs = $by_cat;
                        } else {
                            $blogs = $blogs->merge($by_cat);
                            $blogs->all();
                        }
                    }
                }
                //  If not enough blogs, attach any blogs
                if (empty($blogs) || ($blogs->count() < 3)) {
                    if (empty($blogs)) {
                        $take = 3;
                    } else {
                        $take = 3 - $blogs->count();
                    }
                    $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', '<>', $blog->category_id], ['user_id', '<>', $blog->user_id]);
                    $by_created = $this->blog_rep->get(['alias', 'title', 'created_at'], $take, false, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);
                    if ($by_created) {
                        if (empty($blogs)) {
                            $blogs = $by_created;
                        } else {
                            $blogs = $blogs->merge($by_created);
                            $blogs->all();
                        }
                    }
                }
                //  End Blogs preview

                return view('doc.blog')->with(['blog' => $blog, 'blogs' => $blogs, 'sidebar' => $this->sidebar])->render();
            });
            return $this->renderOutput();
        }

        $this->content = Cache::remember('blogs', 60, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $blogs = $this->blog_rep->get(['title', 'alias', 'created_at'],
                false,
                true,
                $where,
                ['created_at', 'desc'],
                ['blog_img', 'category', 'person'],
                true);
            $cats = $this->cat_rep->get(['name', 'alias']);
            $tags = $this->tag_rep->get(['name', 'alias']);
            return view('doc.blogs')->with(['blogs' => $blogs, 'sidebar' => $this->sidebar, 'cats' => $cats, 'tags' => $tags])->render();
        });

        return $this->renderOutput();
    }

    /**
     * Select crticles by tag
     * @param $tag
     * @return view result
     */
    public function tag($tag = null)
    {
        $this->css = '
                <link rel="stylesheet" type="text/css" href="' . asset('css') . '/statyi.css">
                <link rel="stylesheet" type="text/css" href="' . asset('css') . '/statyi-media.css">
            ';
        $this->sidebar = $this->getSidebar();

        $this->content = Cache::remember('blog-tag-'.$tag->id, 15, function () use ($tag) {
            $blogs = $this->blog_rep->getByTag($tag->id);

            $cats = $this->cat_rep->get(['name', 'alias']);

            return view('doc.blog_tags')
                ->with(['blogs' => $blogs, 'sidebar' => $this->sidebar, 'cats' => $cats, 'tag' => $tag])
                ->render();
        });
        return $this->renderOutput();
    }

    /**
     * Select blogs by category
     * @param $cat
     * @return $this
     */
    public function category($cat = null)
    {
        $this->content = Cache::remember('blog-cat' . $cat->id, 60, function () use ($cat) {

            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', $cat->id] );
            $blogs = $this->blog_rep->get(
                ['title', 'alias'],
                false,
                true,
                $where,
                false,
                ['blog_img', 'category', 'person'],
                true
            );

            $cats = $this->cat_rep->get(['name', 'alias']);
            $tags = $this->tag_rep->get(['name', 'alias']);
            $this->sidebar = $this->getSidebar();
            return view('doc.blogcat')
                ->with(['blogs' => $blogs, 'sidebar' => $this->sidebar, 'cats' => $cats, 'tags' => $tags])
                ->render();
        });

        return $this->renderOutput();
    }

    /**
     * @return bool
     */
    public function getSidebar()
    {
        $sidebar = Cache::remember('blogs_sidebar', 60, function () {
            //            Last 2 events
            $events_rep = new EventsRepository(new Event());
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $lasts = $events_rep->get(['title', 'alias', 'created_at'], 2, false, $where, ['created_at', 'desc']);
            //          most displayed
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $articles = $this->blog_rep->getLast(['title', 'alias', 'created_at'], $where, 2, ['view', 'asc']);

            $advertising = $this->adv_rep->getSidebar('doc');

            return view('doc.blogs_sidebar')
                ->with(['lasts' => $lasts, 'articles' => $articles, 'advertising' => $advertising])
                ->render();
        });
        return $sidebar;
    }
}
