<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // This guard checks whether staff functions can be performed
        Gate::define('can-manage-accounts', function ($user) {
            return $user->role->manage_accounts ? true : false;
        });

        // This guard checks whether a user can manage properties for sale
        Gate::define('can-manage-properties', function ($user) {
            return $user->role->manage_properties ? true : false;
        });
    }
}
