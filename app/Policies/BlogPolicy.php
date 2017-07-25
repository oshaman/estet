<?php

namespace Fresh\Estet\Policies;

use Fresh\Estet\User;
use Fresh\Estet\Blog;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the blog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Blog  $blog
     * @return mixed
     */
    public function view(User $user, Blog $blog)
    {
        return $user->canDo('UPDATE_BLOG');
    }

    /**
     * Determine whether the user can create blogs.
     *
     * @param  \Fresh\Estet\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->canDo('ADD_BLOG');
    }

    /**
     * Determine whether the user can update the blog.
     *
     * @param  \Fresh\Estet\User  $user
     * @param  \Fresh\Estet\Blog  $blog
     * @return mixed
     */
    public function update(User $user, Blog $blog)
    {
        return ($user->canDo('UPDATE_BLOG') && $user->id == $blog->user_id) || $user->canDo('CONFIRMATION_DATA');
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
        return ($user->canDo('CONFIRMATION_DATA'));
    }
}
