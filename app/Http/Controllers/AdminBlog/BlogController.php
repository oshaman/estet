<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Fresh\Estet\Repositories\BlogCategoriesRepository;
use Fresh\Estet\BlogCategory;
use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = '';
        $content = view('blog.index')->with('blogs', $blogs)->render();

        return view('blog.admin')->with('content', $content);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            dd($request->all());
        }

        $title = 'Добавление блога';
        //get categories
        $cats = new BlogCategoriesRepository(new BlogCategory);
        $lists = $cats->catSelect();

        $content = view('blog.add')->with(['content' => $title, 'cats' => $lists])->render();

        return view('blog.admin')->with('content', $content);

    }

    public function edit(Request $request)
    {
        dd('EDIT');
    }
}
