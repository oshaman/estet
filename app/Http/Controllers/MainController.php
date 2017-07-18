<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Fresh\Estet\User;

class MainController extends Controller
{
    public function index()
    {
        $data = 'main';

        return view('main')->with('data', $data);
    }
}
