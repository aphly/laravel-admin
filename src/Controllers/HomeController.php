<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\RoleMenu;
use Illuminate\Support\Facades\Auth;
use Aphly\Laravel\Libs\Helper;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function layout()
    {
        $res['title'] = '';
        $role_id = session('role_id');
        if($role_id){
            $res['menu'] = (new RoleMenu)->getMenu($role_id);
            $res['menu_tree'] = Helper::getTree($res['menu'],true);
            $res['user'] = Auth::guard('manager')->user();
            return $this->makeView('laravel::admin.layout',['res'=>$res]);
        }else{
            throw new ApiException(['code'=>0,'msg'=>'choose role','data'=>['redirect'=>'/admin/role']]);
        }
    }

    public function index()
    {
        $res['title'] = '';
        return $this->makeView('laravel-admin::home.index',['res'=>$res]);
    }

    public function cache()
    {
        Cache::flush();
        throw new ApiException(['code'=>0,'msg'=>'缓存已清空','data'=>['redirect'=>'/admin/index']]);
    }

}
