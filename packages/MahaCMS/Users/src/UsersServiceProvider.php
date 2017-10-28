<?php

namespace MahaCMS\Users;

use Illuminate\Support\ServiceProvider;
use MahaCMS\Users\Models\User;
use MahaCMS\Users\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use MahaCMS\Permissions\PermissionsChecker;

class UsersServiceProvider extends ServiceProvider
{

    protected $policies = [
        User::class => UserPolicy::class
    ];

    protected $permissions = [
        [
            'name' => 'Access Users',
            'perm' => 'users.access',
        ],
        [
            'name' => 'Create User',
            'perm' => 'users.create',
        ],
        [
            'name' => 'Manage Users',
            'perm' => 'users.manage',
        ]
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        PermissionsChecker::check($this->permissions);
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
