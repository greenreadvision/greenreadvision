<?php

namespace App\Http\Middleware;

use Closure;

class Train
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
        if (auth()->user()->status == "train" || auth()->user()->status == "train_OK") {
            return $next($request);
        }
    }
}
