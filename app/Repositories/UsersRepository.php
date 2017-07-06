<?php

namespace Fresh\Estet\Repositories;

use Fresh\Estet\User;
use Gate;

class UsersRepository extends Repository {


    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function updateUser($request, $user)
    {
        if (Gate::denies('edit', $this->model)) {
            abort(404);
        }

        $data = $request->except('_token');

        if(!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else { array_forget($data, 'password');}

        $user->fill($data)->update();
        $user->roles()->sync($data['role_id']);

        return ['status' => trans('admin.user_updated')];

    }

    public function deleteUser($user)
    {
        if (Gate::denies('edit', $this->model)) {
            abort(404);
        }

        $user->roles()->detach();

        if($user->delete()) {
            return ['status' => trans('admin.user_deleted')];
        }
    }
}

?>