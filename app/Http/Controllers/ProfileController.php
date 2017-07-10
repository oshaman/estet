<?php

namespace Fresh\Estet\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Fresh\Estet\User;

use Fresh\Estet\TmpPerson;

class ProfileController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $id = $user->id;
        $sql = User::where('id', $id)->first()->tmpPerson;
        if ($sql) {
            $sql->email = $user->email;
        }
        return view('profile.index')->with('profile', $sql);
    }

    public function update (Request $request)
    {

        if ($request->isMethod('post')) {
            dd($request->except('_token'));
            return redirect('profile');
        }

        $id = Auth::user()->id;
        $sql = User::where('id', $id)->first()->tmpPerson;
//        dd($sql);
        return view('profile.edit')->with('profile', $sql);

    }
}
