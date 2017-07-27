<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Fresh\Estet\BlogCategory;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\Tmpblog;
use Fresh\Estet\Repositories\TmpblogsRepository;
use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;

use Auth;
use Gate;
use Validator;

class BlogController extends Controller
{
    protected $blog_rep;

    public function __construct(TmpblogsRepository $rep)
    {
        $this->blog_rep = $rep;
    }


    public function index(Request $request)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            dd($request);
        }

        $blogs = $this->blog_rep->get(['title', 'id', 'created_at', 'blog_id'], false, true, [['user_id', Auth::id()], ['moderate', false]]);
//        dd($blogs);
        $content = view('blog.index')->with('blogs', $blogs)->render();

        return view('blog.admin')->with('content', $content);
    }

    public function create(Request $request)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }
        /**
         * Store a newly created resource in storage.
         *
         */
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                'title' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\+\"\.]+$#u'],
                'cats' => ['digits_between:1,4', 'nullable'],
                'moder' => 'boolean|nullable',
                'content' => 'string|nullable',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $result = $this->blog_rep->addBlog($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }

            return redirect('/admin-blog')->with($result);
        }
        $title = 'Добавление блога';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();

        $content = view('blog.add')->with(['content' => $title, 'cats' => $lists])->render();

        return view('blog.admin')->with('content', $content);

    }

    public function edit(Request $request, $tmp, $blogid=null)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }
        $title = 'Редактирование блога';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();

        $blog = $this->blog_rep->getBlog($tmp, $blogid);

        $content = view('blog.edit')->with(['content' => $title, 'cats' => $lists, 'blog'=>$blog])->render();

        return view('blog.admin')->with('content', $content);

    }

    public function destroy(Tmpblog $tmpblog)
    {
        dd('destroy');
    }
}
