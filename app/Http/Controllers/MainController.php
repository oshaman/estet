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
        $sql = DB::select('SELECT * FROM `users`');


        return view('main')->with('users', $sql);
    }
}
