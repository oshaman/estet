<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Tmpblog;
use Illuminate\Auth\Access\HandlesAuthorization;

class TmpblogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the tmpblog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Tmpblog  $tmpblog
     * @return mixed
     */
    public function view(User $user, Tmpblog $tmpblog)
    {
        //
    }

    /**
     * Determine whether the user can create tmpblogs.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the tmpblog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Tmpblog  $tmpblog
     * @return mixed
     */
    public function update(User $user, Tmpblog $tmpblog)
    {
        return ($user->canDo('UPDATE_BLOG') && $user->id == $tmpblog->user_id);
    }

    /**
     * Determine whether the user can delete the tmpblog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Tmpblog  $tmpblog
     * @return mixed
     */
    public function delete(User $user, Tmpblog $tmpblog)
    {
        return (($user->canDo('UPDATE_BLOG') && $user->id == $tmpblog->user_id) || $user->hasRole('moderator'));
    }
}
