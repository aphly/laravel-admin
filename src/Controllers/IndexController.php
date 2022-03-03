<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\FailedLogin;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Aphly\Laravel\Libs\Helper;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public $menu_id=1;

    public function layout()
    {
        $res['title']='我的';
        $res['menu'] = (new Role)->getMenu();
        $res['menu_tree'] = Helper::getTree($res['menu'],true);
        Helper::getTreeByid($res['menu_tree'],$this->menu_id,$res['menu_tree']);
        $res['user'] = Auth::guard('manager')->user();
        return $this->makeView('laravel-admin::common.layout',['res'=>$res]);
    }

    public function index()
    {
        $res['title']='我的';
        return $this->makeView('laravel-admin::index.index',['res'=>$res]);
    }

    public function login(loginRequest $request)
    {
        if($request->isMethod('post')) {
            $failedLogin =  new FailedLogin;
            $failedLogin->logincheck($request->ip());
            $credentials = $request->only('username', 'password');
            $credentials['status']=1;
            if (Auth::guard('manager')->attempt($credentials)) {
                throw new ApiException(['code'=>0,'msg'=>'登录成功','data'=>['redirect'=>'/admin/index','manager'=>Auth::guard('manager')->user()->toArray()]]);
            }else{
                $failedLogin->update_failed($request->ip());
            }
        }else{
            $res=['title'=>'后台登录'];
            return $this->makeView('laravel-admin::index.login',['res'=>$res]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        throw new ApiException(['code'=>0,'msg'=>'成功退出','data'=>['redirect'=>'/admin/login']]);
    }

    public function cache()
    {
        Cache::flush();
        throw new ApiException(['code'=>0,'msg'=>'缓存已清空','data'=>['redirect'=>'/admin/index']]);
    }


}
