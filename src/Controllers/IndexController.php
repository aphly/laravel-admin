<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\FailedLogin;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function layout()
    {
        $res=['title'=>'我的'];
        $menu = (new Role)->getMenu();
        $res['user'] = Auth::guard('manager')->user();
        //dd($menu);
        return $this->makeView('laravel-admin::common.layout',['res'=>$res]);
    }

    public function index()
    {
        $res=['title'=>'我的'];
        return $this->makeView('laravel-admin::index.index',['res'=>$res]);
    }

    public function test(Request $request)
    {

        if($request->isMethod('post')) {
            $credentials = $request->only('username');
            throw new ApiException(['code'=>0,'msg'=>'test成功','data'=>$credentials]);
        }else{
            $res=['title'=>'后台登录'];
            return $this->makeView('laravel-admin::index.login',['res'=>$res]);
        }
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


}
