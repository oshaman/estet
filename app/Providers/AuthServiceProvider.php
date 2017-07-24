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
