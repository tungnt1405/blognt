<?php

namespace App\Providers;

use App\Services\Admin\CategoryService;
use App\Services\Admin\PostsService;
use App\Services\Api\OwnerInfoService;
use App\Services\Api\OwnerService;
use App\Services\Interfaces\Admin\CategoryServiceInterface;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use App\Services\Interfaces\Api\OwnerInfoServiceInterface;
use App\Services\Interfaces\Api\OwnerServiceInterface;
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
        // Admin
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        app()->bind(PostsServiceInterface::class, PostsService::class);

        // Api
        app()->bind(OwnerServiceInterface::class, OwnerService::class);
        app()->bind(OwnerInfoServiceInterface::class, OwnerInfoService::class);
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
