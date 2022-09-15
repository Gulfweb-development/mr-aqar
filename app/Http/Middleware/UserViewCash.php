<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use http\Env\Response;
use Illuminate\Filesystem\Cache;


class UserViewCash
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
//        dd(($_COOKIE['user_guest']));

        if (!session()->has('user_guest')) {
            session()->put('user_guest', $request->ip());
//            response('Hello World')->cookie(
//                'user_guest',uniqid()
//            );
        }
//        dd($_COOKIE['user_guest']);

        return $next($request);
    }

}
