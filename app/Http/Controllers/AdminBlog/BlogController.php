<?php

namespace Fresh\Estet\Http\Controllers\AdminBlog;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {

        return view('blog.admin');
    }
}
