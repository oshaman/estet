<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

class SwitchController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->has('doc'));
        if ($request->isMethod('post')) {
            if ($request->has('doc')) {
                $request->session()->put('doc', true);
                return redirect(route('doctors'));
            } else {
                $request->session()->forget('doc');
                return redirect(route('main'));
            }
        }
        return false;
    }
}
