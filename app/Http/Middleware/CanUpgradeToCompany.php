<?php

namespace App\Http\Middleware;

use Closure;

class CanUpgradeToCompany
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
        if (auth()->check()) {
            $balance = \App\Http\Controllers\site\MainController::getBalance();
            if ($balance !== 0 or auth()->user()->type_usage === 'company')
                abort(403);
        } else
            abort(403);
        return $next($request);
    }
}
