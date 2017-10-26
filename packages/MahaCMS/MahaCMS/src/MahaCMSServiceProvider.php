<?php

namespace MahaCMS\MahaCMS;

use Illuminate\Support\ServiceProvider;

class MahaCMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $router->aliasMiddleware('MahaCMS.auth', Middleware\MahaCMSAuth::class);
        //$this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        //$this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->app->register('MahaCMS\Users\UsersServiceProvider');
        $this->app->register('MahaCMS\Roles\RolesServiceProvider');
        $this->app->register('MahaCMS\Permissions\PermissionsServiceProvider');
        $this->app->register('MahaCMS\Blog\BlogServiceProvider');
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
