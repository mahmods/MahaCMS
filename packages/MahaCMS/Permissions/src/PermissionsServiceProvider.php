<?php

namespace MahaCMS\Permissions;

//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use MahaCMS\Permissions\Models\Permission;
use MahaCMS\Permissions\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;

class PermissionsServiceProvider extends ServiceProvider
{

    protected $policies = [
        Permission::class => PermissionPolicy::class
    ];

    protected $permissions = [
        [
            'name' => 'Create Permissions',
            'perm' => 'permissions.create',
        ],
        [
            'name' => 'Manage Permissions',
            'perm' => 'permissions.manage',
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
