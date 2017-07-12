<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;

use Fresh\Estet\TmpPerson;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Gate;

class ProfileController extends AdminController
{
    protected $tmp_rep;
    protected $profile_rep;

    public function __construct(TmpPersonRepository $rep)
    {
        $this->tmp_rep = $rep;
    }

    public function index()
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        $profiles = TmpPerson::with('user')->where('approved', false)->get();

        dd($profiles);
        $this->content = view('admin.profiles.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }
}
