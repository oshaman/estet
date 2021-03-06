<?php

namespace Fresh\Estet\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Fresh\Estet\Permission' => 'Fresh\Estet\Policies\PermissionPolicy',
        'Fresh\Estet\User' => 'Fresh\Estet\Policies\UserPolicy',
        'Fresh\Estet\Blog' => 'Fresh\Estet\Policies\BlogPolicy',
        'Fresh\Estet\Tmpblog' => 'Fresh\Estet\Policies\TmpblogPolicy',
//        'Fresh\Estet\Person' => 'Fresh\Estet\Policies\PersonPolicy',
//        'Fresh\Estet\Specialty' => 'Fresh\Estet\Policies\SpecialtyPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function ($user) {
            return $user->canDo('VIEW_ADMIN', false);
        });

        Gate::define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', false);
        });

        Gate::define('ADMIN_USERS', function ($user) {
            return $user->canDo('ADMIN_USERS', false);
        });

        Gate::define('EDIT_PERMS', function ($user) {
            return $user->canDo('ADMIN_USERS', false);
        });

        Gate::define('UPDATE_BLOG', function ($user) {
            return $user->canDo('UPDATE_BLOG', false);
        });

        Gate::define('UPDATE_CATS', function ($user) {
            return $user->canDo('UPDATE_CATS', false);
        });

        Gate::define('UPDATE_TAGS', function ($user) {
            return $user->canDo('UPDATE_TAGS', false);
        });

        Gate::define('ADD_BLOG', function ($user) {
            return $user->canDo('ADD_BLOG', FALSE);
        });

        Gate::define('DELETE_BLOG', function ($user) {
            return $user->canDo('DELETE_BLOG', FALSE);
        });

        Gate::define('CONFIRMATION_DATA', function ($user) {
            return $user->canDo('CONFIRMATION_DATA', FALSE);
        });

        Gate::define('UPDATE_ESTABLISHMENT', function ($user) {
            return $user->canDo('UPDATE_ESTABLISHMENT', FALSE);
        });

        Gate::define('ADD_ARTICLES', function ($user) {
            return $user->canDo('ADD_ARTICLES', FALSE);
        });

        Gate::define('DELETE_ARTICLES', function ($user) {
            return $user->canDo('DELETE_ARTICLES', FALSE);
        });

        Gate::define('UPDATE_ARTICLES', function ($user) {
            return $user->canDo('UPDATE_ARTICLES', FALSE);
        });

        Gate::define('UPDATE_GOROSCOP', function ($user) {
            return $user->canDo('UPDATE_GOROSCOP', FALSE);
        });

        Gate::define('UPDATE_MENUS', function ($user) {
            return $user->canDo('UPDATE_MENUS', FALSE);
        });

        Gate::define('UPDATE_COMMENTS', function ($user) {
            return $user->canDo('UPDATE_COMMENTS', FALSE);
        });

        Gate::define('UPDATE_PREMIUMS', function ($user) {
            return $user->canDo('UPDATE_PREMIUMS', FALSE);
        });

        Gate::define('UPDATE_GEO', function ($user) {
            return $user->canDo('UPDATE_GEO', FALSE);
        });

        Gate::define('UPDATE_EVENTS', function ($user) {
            return $user->canDo('UPDATE_EVENTS', FALSE);
        });

        Gate::define('UPDATE_SEO', function ($user) {
            return $user->canDo('UPDATE_SEO', FALSE);
        });

        Gate::define('UPDATE_ADVERTISING', function ($user) {
            return $user->canDo('UPDATE_ADVERTISING', FALSE);
        });

        Gate::define('UPDATE_STATIC', function ($user) {
            return $user->canDo('UPDATE_STATIC', FALSE);
        });

        /*Gate::define('UPDATE_ARTICLES', function ($user) {
            return $user->canDo('UPDATE_ARTICLES', FALSE);
        });

        Gate::define('UPDATE_EVENTS', function ($user) {
            return $user->canDo('UPDATE_EVENTS', FALSE);
        });

        Gate::define('CONFIRMATION_DATA', function ($user) {
            return $user->canDo('CONFIRMATION_DATA', FALSE);
        });*/
    }
}
