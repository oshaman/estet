<?php

namespace Fresh\Estet\Http\Middleware;

use Closure;
use Auth;
use Gate;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = false)
    {
        if (Auth::guard($guard)->guest()) {
            return redirect()->guest('login');
        }

        if (Gate::denies('VIEW_ADMIN')) {
            abort(404);
        }

        return $next($request);
    }
}
