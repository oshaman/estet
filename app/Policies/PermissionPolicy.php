<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the permission.
     *
     * @param  Fresh\Estet\User;  $user
     * @param  Fresh\Estet\Permission;  $permission
     * @return mixed
     */
    public function change(User $user) {
        //EDIT_PERMISSIONS
        return $user->canDo('EDIT_PERMS');
    }
}
