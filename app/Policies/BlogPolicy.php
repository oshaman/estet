<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Blog;
use Fresh\Estet\Tmpblog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create people.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function edit(User $user, Tmpblog $tmpblog)
    {
        return ($user->canDo('UPDATE_BLOG') && $user->id == $tmpblog->user_id);
    }
    /**
     * Determine whether the user can update the blog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Blog  $blog
     * @return mixed
     */
    public function update(User $user)
    {
        return ($user->canDo('CONFIRMATION_DATA'));
    }

    /**
     * Determine whether the user can delete the blog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Blog  $blog
     * @return mixed
     */
    public function delete(User $user, Blog $blog)
    {
        return ($user->canDo('DELETE_BLOG'));
    }
}
