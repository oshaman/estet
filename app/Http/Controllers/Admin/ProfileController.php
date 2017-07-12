<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Fresh\Estet\TmpPerson;
use Fresh\Estet\Person;
use Fresh\Estet\Repositories\TmpPersonRepository;
use Fresh\Estet\Repositories\PersonsRepository;
use Gate;
use Config;

class ProfileController extends AdminController
{
    protected $tmp_rep;

    public function __construct(TmpPersonRepository $rep)
    {
        $this->tmp_rep = $rep;
    }

    public function index(Request $request)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            dd($request);
        }

        /*$doc = Person::where('id', 1)->with('specialty')->first();
        dd($doc->specialty[0]->name);*/

        $profiles = $this->tmp_rep->get(['name', 'lastname', 'phone', 'specialty', 'user_id'], false, true, ['approved', false]);

        $this->content = view('admin.profiles.index')->with('profiles', $profiles)->render();
        return $this->renderOutput();
    }

    public function edit (Request $request, $id = null)
    {
        if (Gate::denies('EDIT_USERS')) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $person_rep = new PersonsRepository(new Person);
            $request->request->set('user_id', session('user_id'));
            $result = $person_rep->updatePerson($request);
            dd($result);
        }


       /* if ($request->isMethod('post')) {

            $person_rep = new PersonsRepository;

            $result = $person_rep->updatePerson($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            return redirect()->route('users')->with($result);
        }


        $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);
        $this->content = view('admin.users.edit')->with(['roles'=>$roles,'user'=>$user])->render();*/











        $this->title = 'Редактирование профиля';

        $profile = $this->tmp_rep->findByUserId($id);
        if (!$profile) {
            abort(404);
        }
//        dd($profile);
        $request->session()->flash('user_id', $profile->user_id);
        $this->content = view('admin.profiles.edit')->with(['title'=>$this->title, 'profile'=>$profile])->render();
        return $this->renderOutput();
    }
}
