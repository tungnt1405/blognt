<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetDefaultLocale
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
        $locale = $request->route('locale');
        // if (!$locale) {
        //     $url = str_ireplace('/api/', '/api/' . config('app.locale') . '/', $request->getRequestUri());
        //     return redirect($url);
        // }
        if (isset($locale) && !in_array($locale, config('constants.AVAILABLE_LOCALES'))) {
            $url = str_ireplace("/api/{$locale}", '/api/' . config('app.locale'), $request->getRequestUri());
            return redirect($url);
        }
        return $next($request);
    }
}
