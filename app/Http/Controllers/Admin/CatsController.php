<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Fresh\Estet\Http\Controllers\Admin\AdminController;

class CatsController extends AdminController
{
    protected $cat_rep;

    public function __construct(CatsRepository $rep)
    {
        $this->cat_rep = $rep;
    }
    /**
     * View or Create Categories
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        dd('ADMIN CATS');
    }

}
