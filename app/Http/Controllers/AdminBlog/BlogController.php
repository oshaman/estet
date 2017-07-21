<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

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

    public function create()
    {
        $router = app()->make('router');

//        dd($router->getCurrentRoute()->uri);
        $title = 'Content Index';
        $content = view('blog.add')->with('content', $title)->render();

        return view('blog.admin')->with('content', $content);

    }

    public function edit(Request $request)
    {
        dd('EDIT');
    }
}
