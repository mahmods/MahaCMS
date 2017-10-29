<?php

namespace MahaCMS\Blog;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use MahaCMS\Blog\Models\Post;
use MahaCMS\Blog\Models\Category;
use MahaCMS\Blog\Policies\PostPolicy;
use MahaCMS\Blog\Policies\CategoryPolicy;
use MahaCMS\Permissions\PermissionsChecker;
use Illuminate\Support\Facades\Gate;

class BlogServiceProvider extends ServiceProvider
{
    protected $policies = [
        Post::class => PostPolicy::class,
        Category::class => CategoryPolicy::class
    ];

    protected $permissions = [
        [
            'name' => 'Access Posts',
            'perm' => 'posts.access',
        ],
        [
            'name' => 'Create Posts',
            'perm' => 'posts.create',
        ],
        [
            'name' => 'Manage Posts',
            'perm' => 'posts.manage',
        ],
        [
            'name' => 'Access Categories',
            'perm' => 'categories.access',
        ],
        [
            'name' => 'Create Categories',
            'perm' => 'categories.create',
        ],
        [
            'name' => 'Manage Categories',
            'perm' => 'categories.manage',
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
