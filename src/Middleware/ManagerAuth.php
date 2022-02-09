<?php

namespace Aphly\LaravelAdmin\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class ManagerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            config('admin.manager',Auth::user());
            return redirect('/admin/index');
        }
        return $next($request);
    }

}
