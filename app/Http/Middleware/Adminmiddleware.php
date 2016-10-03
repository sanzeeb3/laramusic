<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Adminmiddleware
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
        if(Auth::check())
        {
            if($request->user()->role==1)
            {
               return $next($request);
            }
             return redirect('/');    
        }

        return redirect('/login');
    }
}
