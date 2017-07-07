<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function view(User $user)
    {
        //
    }
    /**
     * Determine whether the user can create users.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    /*  public function create(User $user)
     {
         return $user->can('EDIT_USERS');
     } */

    public function edit(User $user)
    {
        return $user->can('ADMIN_USERS');
    }
    /**
     * Determine whether the user can delete the user.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        //
    }
}
