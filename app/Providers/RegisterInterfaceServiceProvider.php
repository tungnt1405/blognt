<?php

namespace App\Providers;

use App\Services\Admin\CategoryService;
use App\Services\Admin\PostsService;
use App\Services\Interfaces\Admin\CategoryServiceInterface;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use Illuminate\Support\ServiceProvider;

class RegisterInterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        app()->bind(PostsServiceInterface::class, PostsService::class);

        app()->bind('PostsService', function ($app) {
            return new PostsService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
