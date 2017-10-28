<?php

namespace MahaCMS\Profile;

use Illuminate\Support\Facades\Gate;
use MahaCMS\Profile\Models\Profile;
use MahaCMS\Profile\Policies\ProfilePolicy;
use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        //PermissionsChecker::check($this->permissions);
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
