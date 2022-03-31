<?php

namespace Aphly\LaravelAdmin\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class ManagerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if($request->url() == route('adminLogin')){
            if (Auth::guard('manager')->check()) {
                return redirect('/admin/index');
            }else{
                return $next($request);
            }
        }else{
            if (Auth::guard('manager')->check()) {
                return $next($request);
            }else{
                return redirect()->route('adminLogin');
            }
        }
    }

}
