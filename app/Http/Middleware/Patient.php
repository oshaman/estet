<?php

namespace Fresh\Estet\Http\Middleware;

use Closure;

class Patient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('doc')) {
            $request->session()->forget('doc');
        }

        return $next($request);
    }
}
