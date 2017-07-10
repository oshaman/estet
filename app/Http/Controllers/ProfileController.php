<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index ()
    {
        return view('profile.index');
    }

    public function update (Request $request)
    {
        if ($request->isMethod('post')) {
            return redirect('profile');
        }

        return view('profile.edit');

    }
}
