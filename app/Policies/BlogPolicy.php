<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

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
