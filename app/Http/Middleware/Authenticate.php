<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if(collect($request->route()->middleware())->contains('api')){
            return route('unAuthorize',app()->getLocale());
        }
        if (! $request->expectsJson()) {
            if (in_array($request->segments()[0], ['ar', 'en']))
                $lang = $request->segments()[0];
            else
                $lang = 'en';

            return route('login', $lang);

        }
    }
}
