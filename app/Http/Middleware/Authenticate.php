<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if ((session('userName'))) {
            return $next($request);
        }
        else return redirect(route('signin'));
    }
}
