<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\BlogCategory;
use Fresh\Estet\Repositories\TagsRepository;
use Fresh\Estet\Tag;
use Illuminate\Http\Request;
use Fresh\Estet\Http\Requests\BlogRequest;
use Fresh\Estet\Http\Controllers\Controller;
use Fresh\Estet\BlogImage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = '';
        $content = view('blog.index')->with('blogs', $blogs)->render();

        return view('blog.admin')->with('content', $content);
    }

    public function create(BlogRequest $request)
    {
        if ($request->isMethod('post')) {
            dd($request->all());
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

    public function edit(Request $request)
    {
        dd('EDIT');
    }
}
