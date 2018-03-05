<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminMenu
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
        if(!User::isSuperAdmin())
        {
            abort(401,'权限有误');
        }
        return $next($request);
    }
}
