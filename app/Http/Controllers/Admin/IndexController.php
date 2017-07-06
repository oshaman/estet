<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Controller;

class IndexController extends AdminController
{
    public function index()
    {
        $this->content = view('/admin.content')->with('content', $this->content)->render();

        $this->title = trans('ADMIN PANEL');

        return $this->renderOutput();
    }
}
