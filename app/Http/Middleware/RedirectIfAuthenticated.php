<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            if (auth()->user()->status == "fill") {
                return redirect('/basicInformation');
            } else if (auth()->user()->status == "print") {
                return redirect('/print');
            } else if (auth()->user()->status == "train" || auth()->user()->status == "train_OK") {
                return redirect('/train');
            }else if (auth()->user()->status == "general") {
                return redirect('/home');
            } 
        }

        return $next($request);
    }
}
