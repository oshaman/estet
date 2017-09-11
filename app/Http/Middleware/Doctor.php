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
        if ('Googlebot' == $_SERVER['HTTP_USER_AGENT'] && !session()->has('doc')) {
            session()->put('doc', true);
        }

        if (session()->has('doc')) {
            return $next($request);
        }

        if ($request->hasCookie('user_status')) {
            session()->put('doc', true);
            return $next($request);
        }
        return redirect()->route('main');
    }
}
