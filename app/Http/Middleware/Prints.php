<?php

namespace App\Http\Middleware;

use Closure;

class Prints
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
        if (\Auth::user()->status == "print") {
            return $next($request);
        }
    }
}
