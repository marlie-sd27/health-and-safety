<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ReportAccess
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
        if (Auth::user()->isAdmin() | Auth::user()->isPrincipal() | Auth::user()->isReporter())
        {
            return $next($request);
        }

        else abort(403, 'Unauthorized action');
    }
}
