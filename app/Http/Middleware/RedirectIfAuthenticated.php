<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
        if(Auth::user()->hasRole('operador')){
        return redirect()->route('operador.index');
        }elseif (Auth::user()->hasRole('admin') or Auth::user()->hasRole('super-admin')) {
        return redirect()->route('admin.index');
        }elseif(Auth::user()->hasRole('coordinador')){
        return redirect()->route('coordinador.index');
    }
        }

        return $next($request);
    }
}
