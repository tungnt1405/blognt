<?php

namespace App\Providers;

use App\View\Composers\CountryComposer;

class ComposerServiceProvider extends AppServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.setting.countries'], CountryComposer::class);
    }
}
