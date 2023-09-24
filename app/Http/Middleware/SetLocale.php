<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $lang = in_array($request->segment(2), config('constants.AVAILABLE_LOCALES')) ? $request->segment(2) : env("APP_LANG", 'en');
        // app()->setLocale($lang);
        // URL::defaults(['locale' => $lang]);

        // Nếu có, chúng ta đặt locale này làm mặc định cho ứng dụng (app()->setLocale($locale)) 
        // và nếu không, chúng ta đặt locale mặc định
        if ($locale = $request->route('locale')) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale'));
        }
        return $next($request);
    }
}
