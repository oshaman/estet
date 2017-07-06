<?php

namespace Fresh\Estet\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Gate;
use Fresh\Estet\Repositories\PermissionsRepository;
use Fresh\Estet\Repositories\RolesRepository;


class PermissionsController extends AdminController
{
    protected $per_rep;
    protected $rol_rep;

    public function __construct(PermissionsRepository $per_rep, RolesRepository $rol_rep)
    {
        $this->per_rep = $per_rep;
        $this->rol_rep = $rol_rep;

    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $result = $this->per_rep->changePermissions($request);

            if(is_array($result) && !empty($result['error'])) {
                return back()->with($result);
            }

            return back()->with($result);
        }

        if (Gate::denies('EDIT_PERMS')) {
            abort(404);
        }

        $this->title = trans('admin.perms_menager');

        $roles = $this->getRoles();
        $permissions = $this->getPermissions();

        $this->content = view('admin.permissions.content')->with(['roles'=>$roles, 'priv' => $permissions])->render();

        return $this->renderOutput();
    }

    public function getRoles()
    {
        $roles = $this->rol_rep->get();

        return $roles;
    }

    public function getPermissions()
    {
        $permissions = $this->per_rep->get();

        return $permissions;
    }
}
