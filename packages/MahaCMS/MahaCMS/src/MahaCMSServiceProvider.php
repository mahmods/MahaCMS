<?php

namespace MahaCMS\MahaCMS;

use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use MahaCMS\MahaCMS\Models\Page;
use MahaCMS\MahaCMS\Policies\PagePolicy;

class MahaCMSServiceProvider extends ServiceProvider
{

    protected $policies = [
        Page::class => PagePolicy::class,
    ];

    protected $permissions = [
        [
            'name' => 'Access Pages',
            'perm' => 'pages.access',
        ],
        [
            'name' => 'Create Page',
            'perm' => 'pages.create',
        ],
        [
            'name' => 'Manage Pages',
            'perm' => 'pages.manage',
        ],
        [
            'name' => 'Manage Navigation',
            'perm' => 'navigation.manage',
        ],
        [
            'name' => 'Access Inbox',
            'perm' => 'inbox.access',
        ],
    ];
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->registerPolicies();
        $router->aliasMiddleware('MahaCMS.auth', Middleware\MahaCMSAuth::class);
        $this->publishes([__DIR__.'/Config/mahacms.php' => config_path('mahacms.php')], 'mahacms_config');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->app->register('MahaCMS\Users\UsersServiceProvider');
        $this->app->register('MahaCMS\Roles\RolesServiceProvider');
        $this->app->register('MahaCMS\Permissions\PermissionsServiceProvider');
        $this->app->register('MahaCMS\Blog\BlogServiceProvider');
        $this->app->register('MahaCMS\Settings\SettingsServiceProvider');
        $this->app->register('MahaCMS\Profile\ProfileServiceProvider');
        $this->app->register('MahaCMS\CRUD\CRUDServiceProvider');
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
