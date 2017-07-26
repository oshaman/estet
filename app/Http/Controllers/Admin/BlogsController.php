<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Fresh\Estet\Tag;
use Fresh\Estet\Repositories\TagsRepository;
use Fresh\Estet\BlogCategory;
use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\Blog;
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
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true);
                    break;
                case 4:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['user_id', $data['value']]);
                    break;
                default:
                    $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0]);
            }
            $this->content = view('admin.blog.index')->with('blogs', $blogs)->render();

            return $this->renderOutput();
        }

        $blogs = $this->blog_rep->get(['title', 'id', 'alias', 'created_at'], false, true, ['approved', 0]);
        $this->content = view('admin.blog.index')->with('blogs', $blogs)->render();

        return $this->renderOutput();
    }

    public function edit(BlogRequest $request, $blog)
    {
        if (Gate::denies('update', new Blog)) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            dd($request);
        }

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

        $img = $blog->blog_img->path;
//        dd($content);

        $this->content = view('admin.blog.edit')->with(['title' => $title, 'cats' => $lists, 'tags'=>$tag, 'content'=>$blog, 'img'=>$img])->render();

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
