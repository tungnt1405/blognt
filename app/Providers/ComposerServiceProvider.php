<?php

namespace App\Providers;

use App\View\Composers\CountryComposer;
use App\View\Composers\OwnerComposer;

class ComposerServiceProvider extends AppServiceProvider
{
    /**
     * @var \App\Services\Admin\CategoryService $categoryService
     */
    protected $categoryService;

    /**
     * @var \App\Services\Admin\PostsService $categoryService
     */
    protected $postsService;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->categoryService = new \App\Services\Admin\CategoryService();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.setting.countries', 'admin.profile.change-language-form'], CountryComposer::class);
        view()->composer(['admin.side-bar.show', 'admin.side-bar.more-info'], OwnerComposer::class);
        view()->composer(['admin.setting.categories', 'admin.posts.index'], function ($view) {
            $categories  = $this->categoryService->all();
            $view->with('categories', $categories);
        });
    }
}
