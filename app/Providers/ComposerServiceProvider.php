<?php

namespace App\Providers;

use App\View\Composers\CountryComposer;
use App\View\Composers\OwnerComposer;

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
        view()->composer(['admin.setting.countries', 'admin.profile.change-language-form'], CountryComposer::class);
        view()->composer(['admin.side-bar.show', 'admin.side-bar.more-info'], OwnerComposer::class);
    }
}
