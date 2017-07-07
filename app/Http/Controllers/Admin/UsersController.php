<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Fresh\Estet\Repositories\RolesRepository;
use Fresh\Estet\Repositories\UsersRepository;
use Fresh\Estet\User;
use Fresh\Estet\Http\Requests\UserRequest;
use Gate;

class UsersController extends AdminController
{
    protected $us_rep;
    protected $rol_rep;
    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep) {
        $this->us_rep = $us_rep;
        $this->rol_rep = $rol_rep;
    }

    public function index()
    {
        if (Gate::denies('ADMIN_USERS')) {
            abort(404);
        }
        $this->title = trans('admin.users_manager');
        $users = $this->us_rep->get('*', false, true, false, false);

        $this->content = view('admin.users.content')->with('users', $users)->render();
        return $this->renderOutput();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $request, User $user)
    {
        if ($request->isMethod('post')) {
            $result = $this->us_rep->updateUser($request, $user);
            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }
            return redirect()->route('users')->with($result);
        }

        if (Gate::denies('ADMIN_USERS')) {
            abort(404);
        }
        $this->title =  trans('admin.user_edit') .' - '. $user->email;

        $roles = $this->getRoles()->reduce(function ($returnRoles, $role) {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);
        $this->content = view('admin.users.edit')->with(['roles'=>$roles,'user'=>$user])->render();

        return $this->renderOutput();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Gate::denies('ADMIN_USERS')) {
            abort(404);
        }
        $result = $this->us_rep->deleteUser($user);
        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('users')->with($result);
    }

    public function getRoles()
    {
        return \Fresh\Estet\Role::all();
    }
}
