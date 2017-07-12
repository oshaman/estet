<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Specialty;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialtyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the specialty.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Specialty  $specialty
     * @return mixed
     */
    public function view(User $user, Specialty $specialty)
    {
        //
    }

    /**
     * Determine whether the user can create specialties.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the specialty.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Specialty  $specialty
     * @return mixed
     */
    public function update(User $user, Specialty $specialty)
    {
        //
    }

    /**
     * Determine whether the user can delete the specialty.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Specialty  $specialty
     * @return mixed
     */
    public function delete(User $user, Specialty $specialty)
    {
        //
    }
}
