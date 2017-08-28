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
        if ('Googlebot' == $_SERVER['HTTP_USER_AGENT']) {
            session()->put('doc', true);
        }

        if (!session()->has('doc')) {
            return redirect()->back();
        }
        return $next($request);
    }
}
