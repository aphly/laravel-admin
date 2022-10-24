<?php

namespace Aphly\LaravelAdmin\Middleware;

use Aphly\LaravelAdmin\Models\Banned;
use Illuminate\Http\Request;
use Closure;

class Common
{
    public function handle(Request $request, Closure $next)
    {
        $banned = Banned::where('ip',$request->ip())->where('status',1)->first();
        if(!empty($banned)){
            if($request->url() == route('banned')){
                return $next($request);
            }else{
                return redirect()->route('banned');
            }
        }else{
            return $next($request);
        }
    }

}
