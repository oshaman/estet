<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\BlogCategory;
use Illuminate\Http\Request;
use Fresh\Estet\Http\Requests\BlogRequest;
use Fresh\Estet\Http\Controllers\Controller;
use Fresh\Estet\BlogImage;
use Fresh\Estet\Blog;
use Fresh\Estet\Repositories\BlogsRepository;
use Auth;

use Gate;

class BlogController extends Controller
{
    protected $blog_rep;

    public function __construct(BlogsRepository $rep)
    {
        $this->blog_rep = $rep;
    }


    public function index(BlogRequest $request)
    {
        if (Gate::denies('UPDATE_BLOG')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            dd($request);
        }

        $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['user_id', Auth::user()->id]);
        $content = view('blog.index')->with('blogs', $blogs)->render();

        return view('blog.admin')->with('content', $content);
    }

    public function create(BlogRequest $request)
    {
        if (Gate::denies('create', new Blog)) {
            abort(404);
        }
        /**
         * Store a newly created resource in storage.
         *
         */
        if ($request->isMethod('post')) {
            $result = $this->blog_rep->addBlog($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
//            dd($result);

            return redirect('/admin-blog')->with($result);
        }
        $title = 'Добавление блога';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();
        //  get tags
        $tags = new TagsRepository(new Tag);
        $tag = $tags->tagSelect();

        $content = view('blog.add')->with(['content' => $title, 'cats' => $lists, 'tags'=>$tag])->render();

        return view('blog.admin')->with('content', $content);

    }

    public function edit(Request $request, $blog)
    {
        if (Gate::denies('delete')) {
            abort(404);
        }
    }
}
