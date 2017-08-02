<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

use Fresh\Estet\Http\Controllers\DocsController;
use Fresh\Estet\Blog;
use Fresh\Estet\Repositories\BlogsRepository;

use DB;

class BlogsController extends DocsController
{
    protected $blog_rep;

    public function __construct(BlogsRepository $rep)
    {
        $this->blog_rep = $rep;
    }

    public function index($blog_alias=false)
    {


        if ($blog_alias) {
            $blog = $this->blog_rep->one($blog_alias, true);
            $this->content = view('doc.blog')->with('blog', $blog)->render();
            return $this->renderOutput();
        }
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
        $blogs = $this->blog_rep->get(['title', 'alias', 'created_at'], false, true, $where, ['created_at', 'desc'], ['blog_img', 'category', 'person'], true);

        $this->content = view('doc.blogs')->with('blogs', $blogs)->render();
        return $this->renderOutput();
    }
}
