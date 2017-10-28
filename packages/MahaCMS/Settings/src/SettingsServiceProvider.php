<?php

namespace MahaCMS\Settings;

use Illuminate\Support\Facades\Gate;
use MahaCMS\Settings\Models\Setting;
use MahaCMS\Settings\Policies\SettingPolicy;
use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{

    protected $policies = [
        Setting::class => SettingPolicy::class,
    ];

    protected $permissions = [
        [
            'name' => 'Access Settings',
            'perm' => 'settings.access',
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
