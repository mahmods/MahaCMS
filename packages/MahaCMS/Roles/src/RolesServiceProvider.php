<?php

namespace MahaCMS\Roles;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use MahaCMS\Roles\Models\Role;
use MahaCMS\Roles\Policies\RolePolicy;
use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{

    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    protected $permissions = [
        [
            'name' => 'Create Roles',
            'perm' => 'roles.create',
        ],
        [
            'name' => 'Manage Roles',
            'perm' => 'roles.manage',
        ],
        [
            'name' => 'Manage Role Permissions',
            'perm' => 'roles.permissions',
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
