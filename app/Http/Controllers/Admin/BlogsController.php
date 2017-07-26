<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;

use Fresh\Estet\Repositories\BlogsRepository;

use Gate;
use Auth;

use Fresh\Estet\Http\Requests\BlogRequest;

class BlogsController extends AdminController
{
    protected $blog_rep;

    public function __construct(BlogsRepository $rep)
    {
        $this->blog_rep = $rep;
    }

    public function index(BlogRequest $request)
    {
        if (Gate::denies('DELETE_BLOG')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            dd($request);
        }

        $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0]);
        $this->content = view('admin.blog.index')->with('blogs', $blogs)->render();

        return $this->renderOutput();
    }
}
