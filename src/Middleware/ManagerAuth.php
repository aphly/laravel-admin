<?php

namespace Aphly\LaravelAdmin\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class ManagerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->path()=='admin/login'){
            if (Auth::guard('manager')->check()) {
                return redirect('/admin/index');
            }else{
                return $next($request);
            }
        }else{
            if (Auth::guard('manager')->check()) {
                //config('admin.manager',Auth::guard('manager')->user()->toArray());
                return $next($request);
            }else{
                return redirect('/admin/login');
            }
        }
    }

}
