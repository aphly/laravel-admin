<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Seccode;
use Aphly\LaravelAdmin\Models\FailedLogin;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Aphly\Laravel\Libs\Helper;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    //public $menu_id=1;

    public function layout()
    {
        $res['title'] = '';
        $res['menu'] = (new Role)->getMenu();
        $res['menu_tree'] = Helper::getTree($res['menu'],true);
        //Helper::getTreeByid($res['menu_tree'],$this->menu_id,$res['menu_tree']);
        $res['user'] = Auth::guard('manager')->user();
        return $this->makeView('laravel-admin::common.layout',['res'=>$res]);
    }

    public function index()
    {
        $res['title'] = '';
        return $this->makeView('laravel-admin::home.index',['res'=>$res]);
    }

    public function login(loginRequest $request)
    {
        if($request->isMethod('post')) {
            if (config('admin.seccode_admin_login')==1) {
                if (!((new Seccode())->check($request->input('code')))) {
                    throw new ApiException(['code' => 11000, 'msg' => 'Incorrect Code', 'data' => ['code' => ['Incorrect Code']]]);
                }
            }
            $failedLogin =  new FailedLogin;
            $failedLogin->loginCheck($request);
            $credentials = $request->only('username', 'password');
            $credentials['status']=1;
            if (Auth::guard('manager')->attempt($credentials)) {
                throw new ApiException(['code'=>0,'msg'=>'登录成功','data'=>['redirect'=>'/admin/index','manager'=>Auth::guard('manager')->user()->toArray()]]);
            }else{
                $failedLogin->updateFailed($request);
            }
        }else{
            $res['title'] = '';
            return $this->makeView('laravel-admin::home.login',['res'=>$res]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('manager')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        throw new ApiException(['code'=>0,'msg'=>'成功退出','data'=>['redirect'=>'/admin/login']]);
    }

    public function cache()
    {
        Cache::flush();
        throw new ApiException(['code'=>0,'msg'=>'缓存已清空','data'=>['redirect'=>'/admin/index']]);
    }


}
