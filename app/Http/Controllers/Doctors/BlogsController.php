<?php

namespace Fresh\Estet\Http\Controllers\Doctors;

use Fresh\Estet\Repositories\BlogsRepository;
use DB;
use Cache;

class BlogsController extends DocsController
{
    protected $blog_rep;

    public function __construct(BlogsRepository $rep)
    {
        $this->blog_rep = $rep;
    }

    /**
     * @param  $blog_alias
     * @return $this
     */
    public function index($blog_alias=false)
    {
        if ($blog_alias) {

            $blog = Cache::remember('blog-'.$blog_alias, '10', function() use ($blog_alias) {
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
                    $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', $blog->category_id], ['user_id', '!=', $blog->user_id]);
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
                    $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', '!=', $blog->category_id], ['user_id', '!=', $blog->user_id]);
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

                return view('doc.blog')->with(['blog' => $blog, 'blogs' => $blogs])->render();
            });
            return $this->renderOutput();
        }

        $this->content = Cache::remember('blogs', 10, function () {
            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
            $blogs = $this->blog_rep->get(['title', 'alias', 'created_at'], false, true, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);

            return view('doc.blogs')->with('blogs', $blogs)->render();
        });

        return $this->renderOutput();
    }

    /**
     * Select crticles by tag
     * @param $tag
     * @return view result
     */
    public function tag($tag)
    {
        $this->content = Cache::remember('blog-tag-'.$tag->id, 15, function () use ($tag) {
            $blogs = $this->blog_rep->getByTag($tag->id);

            return view('blog.tags')->with(['blogs' => $blogs])->render();
        });
        return $this->renderOutput();
    }

    /**
     * Select blogs by category
     * @param $cat
     * @return $this
     */
    public function category($cat)
    {
        $this->content = Cache::remember('blog-cat'.$cat->id, 15, function() use ($cat) {

            $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')], ['category_id', $cat->id] );
            $blogs = $this->blog_rep->get(['title', 'alias'], false, true, $where);

            return view('doc.blogcat')->with(['blogs' => $blogs])->render();
        });

        return $this->renderOutput();
    }
}
