<?php

namespace Fresh\Estet\Http\Controllers;

use Cookie;
use Illuminate\Http\Request;

class SwitchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($request->has('doc')) {
                $request->session()->put('doc', true);
                if ($request->has('remember')) {
                    Cookie::queue('user_status', 'doc', 24 * 60);
                }
                return redirect(route('doctors'));
            } else {
                $request->session()->forget('doc');
                return redirect(route('main'));
            }
        }
        return false;
    }
}
