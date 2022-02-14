<?php

namespace Aphly\LaravelAdmin\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;

class Rbac
{
    public function handle(Request $request, Closure $next)
    {
        if( !$this->checkPrivilege( $action->getUniqueId() ) ){
            $this->redirect( UrlService::buildUrl( "/error/forbidden" ) );
            return false;
        }
        return $next($request);
    }

    public function checkPrivilege( $url ){
        //如果是超级管理员 也不需要权限判断
        if( $this->current_user && $this->current_user['is_admin'] ){
            return true;
        }

        //有一些页面是不需要进行权限判断的
        if( in_array( $url,$this->ignore_url ) ){
            return true;
        }

        return in_array( $url, $this->getRolePrivilege( ) );
    }

    public function getRolePrivilege($uid = 0){
        if( !$uid && $this->current_user ){
            $uid = $this->current_user->id;
        }

        if( !$this->privilege_urls ){
            $role_ids = UserRole::find()->where([ 'uid' => $uid ])->select('role_id')->asArray()->column();
            if( $role_ids ){
                //在通过角色 取出 所属 权限关系
                $access_ids = RoleAccess::find()->where([ 'role_id' =>  $role_ids ])->select('access_id')->asArray()->column();
                //在权限表中取出所有的权限链接
                $list = Access::find()->where([ 'id' => $access_ids ])->all();
                if( $list ){
                    foreach( $list as $_item  ){
                        $tmp_urls = @json_decode(  $_item['urls'],true );
                        $this->privilege_urls = array_merge( $this->privilege_urls,$tmp_urls );
                    }
                }
            }
        }
        return $this->privilege_urls ;
    }

}
