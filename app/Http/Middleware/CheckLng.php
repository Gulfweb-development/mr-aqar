<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLng
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (Auth::check() && Auth::user()->lng){
        //     app()->setLocale(Auth::user()->lng);
        // }
        if ($request['locale']){
            app()->setLocale($request['locale']);
        }
//        dd(app()->getLocale());

        return $next($request);
    }
}
