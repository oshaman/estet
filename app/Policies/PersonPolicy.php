<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Person;
use Illuminate\Auth\Access\HandlesAuthorization;

class PersonPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the person.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Person  $person
     * @return mixed
     */
    public function view(User $user, Person $person)
    {
        //
    }

    /**
     * Determine whether the user can create people.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the person.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Person  $person
     * @return mixed
     */
    public function update(User $user, Person $person)
    {
        //
    }

    /**
     * Determine whether the user can delete the person.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Person  $person
     * @return mixed
     */
    public function delete(User $user, Person $person)
    {
        return $user->canDo('EDIT_USERS');
    }
}
