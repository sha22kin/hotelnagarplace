<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(Auth::check() && url('log-out')!==$request->url()){
            // Already logged in: admins go to the admin panel, everyone else to their dashboard.
            if(Auth::user()->admin){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('customer.dashboard');
        }
        return $next($request);
    }
}
