<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Fresh\Estet\BlogCategory;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\Http\Requests\TmpblogRequest;
use Fresh\Estet\Tmpblog;
use Fresh\Estet\Blog;
use Fresh\Estet\Repositories\BlogsRepository;
use Fresh\Estet\Repositories\TmpblogsRepository;
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


    public function index(TmpblogRequest $request)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            $data = $request->except('_token');

            switch ($data['param']) {
                case 1:
                    $blogs = $this->blog_rep->get(['title', 'id', 'created_at', 'blog_id'], false, true, [['user_id', Auth::id()], ['moderate', true]]);
                    break;
                case 2:
                    $model = new BlogsRepository(new Blog);
                    $blogs = $model->get(['title', 'id', 'created_at'], false, true, [['user_id', Auth::id()], ['alias', $data['value']]]);
                    break;
                case 3:
                    $model = new BlogsRepository(new Blog);
                    $blogs = $model->get(['title', 'id', 'created_at'], false, true, [['user_id', Auth::id()], ['title', $data['value']]]);
                    break;
                case 4:
                    $model = new BlogsRepository(new Blog);
                    $blogs = $model->get(['title', 'id', 'created_at'], false, true, ['user_id', Auth::id()]);
                    break;
                default:
                    $model = new BlogsRepository(new Blog);
                    $blogs = $model->get(['title', 'id', 'created_at'], false, true, ['user_id', Auth::id()]);
            }

            $content = view('blog.index')->with('blogs', $blogs)->render();

            return view('blog.admin')->with('content', $content);
        }

        $blogs = $this->blog_rep->get(['title', 'id', 'created_at', 'blog_id'], false, true, [['user_id', Auth::id()], ['moderate', false]]);

        $content = view('blog.index')->with('blogs', $blogs)->render();

        return view('blog.admin')->with('content', $content);
    }

    /**
     * @param TmpblogRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(TmpblogRequest $request)
    {
        if (Gate::denies('ADD_BLOG')) {
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
            $request->session()->forget('blog_id');
            $request->session()->forget('image');
            return redirect('/admin-blog')->with($result);
        }
        $title = 'Добавление блога';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();

        $content = view('blog.add')->with(['content' => $title, 'cats' => $lists])->render();

        return view('blog.admin')->with('content', $content);

    }

    /**
     * @param TmpblogRequest $request
     * @param TMP blog ID $tmp
     * @param Blog ID (if exist) $blogid
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit(TmpblogRequest $request, $tmp, $blogid=null)
    {
        if (Gate::denies('ADD_BLOG')) {
            abort(404);
        }

        if ($request->isMethod('post')) {

            $result = $this->blog_rep->updateBlog($request, $tmp);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            $request->session()->forget('blog_id');
            $request->session()->forget('image');
            return redirect('/admin-blog')->with($result);
        }

        $title = 'Редактирование блога';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();

        $blog = $this->blog_rep->getBlog($tmp, $blogid);

        if (false == $blog) {
            abort(404);
        }
        if (!empty($blog->blog_session)) {
            $request->session()->put('blog_id', $blog->blog_session);
            $request->session()->put('image', $blog->image);
        }

        $content = view('blog.edit')->with(['content' => $title, 'cats' => $lists, 'blog'=>$blog])->render();

        return view('blog.admin')->with('content', $content);

    }

    /**
     * @param Tmpblog $tmpblog
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tmpblog $tmpblog)
    {
        $result = $this->blog_rep->deleteBlog($tmpblog);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect('/admin-blog')->with($result);;
    }
}
