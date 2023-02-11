<?php

namespace App\Providers;

use App\Http\Livewire\Admin\Posts\Create;
use App\Http\Livewire\Admin\Posts\Show;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Livewire::component('admin.posts.create', Create::class);
        Livewire::component('admin.posts.show', Show::class);
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
