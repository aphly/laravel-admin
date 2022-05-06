<?php

namespace Aphly\LaravelAdmin\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class UserAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->path()=='login' || $request->path()=='register'){
            if (Auth::guard('user')->check()) {
                return redirect('/index');
            }else{
                return $next($request);
            }
        }else{
            if (Auth::guard('user')->check()) {
                return $next($request);
            }else{
                return redirect('/login');
            }
        }
    }

}
