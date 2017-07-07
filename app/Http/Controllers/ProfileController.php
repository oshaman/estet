<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            dd('post');
        }

        return view();
    }
}
