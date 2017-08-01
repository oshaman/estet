<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Tag;
use Fresh\Estet\Repositories\TagsRepository;
use Fresh\Estet\BlogCategory;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\Blog;
use Fresh\Estet\Repositories\BlogsRepository;
use Fresh\Estet\Tmpblog;
use Fresh\Estet\Repositories\TmpblogsRepository;


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

    /**
     *
     * @param BlogRequest $request
     * @return view
     */
    public function index(BlogRequest $request)
    {
        if (Gate::denies('DELETE_BLOG')) {
            abort(404);
        }
        if ($request->isMethod('post')) {

            $data = $request->except('_token');

            switch ($data['param']) {
                case 1:
                   $blogs[] = $this->blog_rep->one($data['value']);
                    break;
                case 2:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['title', $data['value']]);
                    break;
                case 3:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0]);
                    break;
                case 4:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true);
                    break;
                case 5:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['user_id', $data['value']]);
                    break;
                default:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0]);
            }
//            dd($blogs);
            $this->content = view('admin.blog.index')->with('blogs', $blogs)->render();

            return $this->renderOutput();
        }



        $rep = new TmpblogsRepository(new Tmpblog);

        $blogs = $rep->get(['title', 'id', 'created_at', 'blog_id'], false, true, ['moderate', 1]);

        $this->content = view('admin.blog.index')->with('blogs', $blogs)->render();

        return $this->renderOutput();
    }

    /**
     * @param BlogRequest $request
     * @param null $tmpblog
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function create(BlogRequest $request, $tmpblog=null)
    {
        if (Gate::denies('DELETE_BLOG')) {
            abort(404);
        }
//      Create Blog
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'alias' => 'required|unique:blogs,alias|max:255',
            ]);
            $result = $this->blog_rep->addBlog($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }

        if (key_exists('status', $result)) {
            $rep = new TmpblogsRepository(new Tmpblog);
            $rep->deleteBlog(Tmpblog::find($request->session()->get('tmp_id')));
        }
            $request->session()->forget('tmp_id');
            $request->session()->forget('user_id');
            $request->session()->forget('image');


            return redirect()->route('view_blogs')->with($result);
        }

//        View FORMS
        $title = 'Добавление статьи блога';
        $this->template = 'admin.blog.admin';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();
        //  get tags
        $tags = new TagsRepository(new Tag);
        $tag = $tags->tagSelect();

        if (null == $tmpblog) {
            abort(404);
        }

        $request->session()->flash('user_id', $tmpblog->user_id);
        $request->session()->flash('tmp_id', $tmpblog->id);
        if (!empty($tmpblog->image)) {
            $request->session()->flash('image', $tmpblog->image);
        }
        $this->content = view('admin.blog.add')->with(['title' => $title, 'cats' => $lists, 'tags'=>$tag, 'content'=>$tmpblog])->render();

        return $this->renderOutput();
    }

    public function edit(BlogRequest $request, $blog)
    {
        if (Gate::denies('update', new Blog)) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $result = $this->blog_rep->updateBlog($request, $blog);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            if (key_exists('status', $result)) {
                $rep = new TmpblogsRepository(new Tmpblog);
                $id = Tmpblog::find($request->session()->get('tmp_id'));
                if ($id) {
                    $rep->deleteBlog($id);
                }
            }
            $request->session()->forget('tmp_id');
            $request->session()->forget('image');


            return redirect()->route('view_blogs')->with($result);
        }

        // View edit forms
        $title = 'Редактирование статей блога';
        $this->template = 'admin.blog.admin';
        //  get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();
        //  get tags
        $tags = new TagsRepository(new Tag);
        $tag = $tags->tagSelect();

        if (null == $blog) {
            abort(404);
        }

        $tmp = Tmpblog::where('blog_id', $blog->id)->get();

//        dd($tmp->isNotEmpty());
        if ($tmp->isNotEmpty()) {
            $request->session()->put('image', $tmp[0]->image);
            $request->session()->put('tmp_id', $tmp[0]->id);
            $tmp = $tmp[0];
        } else {
            $tmp = null;
        }
        $img = $blog->blog_img;

        if (is_string($blog->seo) && is_object(json_decode($blog->seo)) && (json_last_error() == JSON_ERROR_NONE)) {
            $blog->seo = json_decode($blog->seo);
        }
        $this->content = view('admin.blog.edit')->with(['title' => $title, 'cats' => $lists, 'tags'=>$tag, 'content'=>$blog, 'img'=>$img, 'tmp'=>$tmp])->render();

        return $this->renderOutput();
    }

    public function destroy(Blog $blog)
    {
        if (Gate::denies('delete', $blog)) {
            abort(404);
        }

        $result = $this->blog_rep->deleteBlog($blog);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('view_blogs')->with($result);
    }
}
