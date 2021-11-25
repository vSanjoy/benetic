<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use App;
use Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!\Auth::guard('web')->check()) {
            return Redirect::route('/');
        }
        return $next($request);
    }
}
