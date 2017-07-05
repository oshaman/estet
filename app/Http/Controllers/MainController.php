<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MainController extends Controller
{
    public function index()
    {
        $sql = DB::select('SELECT * FROM `users`');
        dump($sql);
    }
}
