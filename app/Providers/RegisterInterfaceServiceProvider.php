<?php

namespace App\Providers;

use App\Services\Admin\CategoryService;
use App\Services\Admin\PostsService;
use App\Services\Api\ApiCategoryService;
use App\Services\Api\OwnerInfoService;
use App\Services\Api\OwnerService;
use App\Services\Api\PostService;
use App\Services\Interfaces\Admin\CategoryServiceInterface;
use App\Services\Interfaces\Admin\PostsServiceInterface;
use App\Services\Interfaces\Api\ApiCategoryServiceInterface;
use App\Services\Interfaces\Api\OwnerInfoServiceInterface;
use App\Services\Interfaces\Api\OwnerServiceInterface;
use App\Services\Interfaces\Api\PostServiceInterface;
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
        // Tham khảo: https://freetuts.net/service-container-trong-laravel-5734.html
        // Admin
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        app()->bind(PostsServiceInterface::class, PostsService::class);

        // Api
        app()->bind(OwnerServiceInterface::class, OwnerService::class);
        app()->bind(OwnerInfoServiceInterface::class, OwnerInfoService::class);
        app()->bind(PostServiceInterface::class, PostService::class);
        app()->bind(ApiCategoryServiceInterface::class, ApiCategoryService::class);
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
