<?php

namespace MahaCMS\CRUD;

use Illuminate\Support\Facades\Gate;
use MahaCMS\CRUD\Models\Table;
use MahaCMS\CRUD\Policies\TablePolicy;
use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class CRUDServiceProvider extends ServiceProvider
{

    protected $policies = [
        Table::class => TablePolicy::class,
    ];

    protected $permissions = [
        [
            'name' => 'Access CRUD',
            'perm' => 'crud.access',
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
