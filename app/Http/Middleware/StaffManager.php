<?php

namespace App\Http\Middleware;

use Closure;

class StaffManager
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
        if (auth()->user()->status == 'general' &&(auth()->user()->role == "proprietor" || auth()->user()->role == "manager" || auth()->user()->role == "supervisor")) {
            return $next($request);
        }
    }
}
