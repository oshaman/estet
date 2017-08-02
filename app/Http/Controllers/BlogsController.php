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

    public function index($blog=false)
    {
        $where = array(['approved', true], ['created_at', '<=', DB::raw('NOW()')]);
        $blogs = $this->blog_rep->get(['title', 'alias', 'created_at'], false, true, $where, false, ['blog_img', 'category', 'person']);

//        dd($blogs);

        $this->content = view('doc.blogs')->with('blogs', $blogs)->render();
        return $this->renderOutput();
    }
}
