<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        "admin_blog",
        "admin_blog/*",
        "maintain",
        "assets",
        "assets/*",
        "build",
        "build/*",
        "livewire",
        "livewire/*",
        "api/website-info"
        // "_debugbar/assets/*" // chỉ sử dụng trên local và test nên cần debug hay phát triển thì open
    ];
}
