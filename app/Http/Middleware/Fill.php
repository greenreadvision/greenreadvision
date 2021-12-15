<?php

namespace App\Http\Middleware;

use Closure;

class Fill
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
        if (\Auth::user()->status == "fill") {
            return $next($request);
        }
    }
}
