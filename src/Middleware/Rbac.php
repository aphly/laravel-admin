<?php

namespace Aphly\LaravelAdmin\Middleware;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\RolePermission;
use Aphly\LaravelAdmin\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class Rbac
{
    public $ignore_url = [];

    public function handle(Request $request, Closure $next)
    {
        if( !$this->checkPermission( $request->route()->getAction()['controller'] ) ){
            throw new ApiException(['code'=>1,'msg'=>'没有权限']);
        }
        return $next($request);
    }

    public function checkPermission( $controller ){
        if(Auth::guard('manager')->id()==1){
            return true;
        }
        if( in_array( $controller,$this->ignore_url ) ){
            return true;
        }
        return in_array( $controller, $this->getRolePermission());
    }

    public function getRolePermission(){
        $role_ids = UserRole::where([ 'uuid' => Auth::guard('manager')->user()->uuid ])->select('role_id')->get()->toArray();
        $role_ids = array_column($role_ids,'role_id');
        $role_permission = (new RolePermission)->role_permission_cache();
        $has_permission = [];
        foreach($role_ids as $id){
            if(isset($role_permission[$id])){
                foreach ($role_permission[$id] as $k=>$v){
                    $has_permission[$k] = $v;
                }
            }
        }
        return $has_permission;
    }

    public function getRolePermission_bf(){
        $role_ids = UserRole::where([ 'uuid' => Auth::guard('manager')->user()->uuid ])->select('role_id')->get()->toArray();
        $role_ids = array_column($role_ids,'role_id');
        $permission = RolePermission::whereIn('role_id',$role_ids)->with('permission')->get()->toArray();
        $has_permission = [];
        foreach ($permission as $v){
            $has_permission[$v['permission']['id']] = $v['permission']['controller'];
        }
        return $has_permission;
    }

}
