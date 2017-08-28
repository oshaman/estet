<?php

namespace Fresh\Estet\Http\Middleware;

use Closure;

class Doctor
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
        if (!session()->has('doc') || !('Googlebot' == $_SERVER['HTTP_USER_AGENT'])) {
            return redirect()->back();
        }
        return $next($request);
    }
}
