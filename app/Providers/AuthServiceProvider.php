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
            return $user->canDo('VIEW_ADMIN', FALSE);
        });

        Gate::define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', FALSE);
        });

        Gate::define('ADMIN_USERS', function ($user) {
            return $user->canDo('ADMIN_USERS', FALSE);
        });

        Gate::define('EDIT_PERMS', function ($user) {
            return $user->canDo('ADMIN_USERS', FALSE);
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
