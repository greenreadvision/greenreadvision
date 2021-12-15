<?php

namespace App\Http\Middleware;

use Closure;

class General
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
       if(\Auth::user()->status == "general"){
        return $next($request);
       }
    }
}
