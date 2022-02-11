<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\FailedLogin;
use Aphly\LaravelAdmin\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function layout()
    {
        $res=['title'=>'我的'];
        return view('admin.layout',['res'=>$res]);
    }

    public function index()
    {
        $res=['title'=>'我的'];
        return view('admin.index.index',['res'=>$res]);
    }

    public function login(loginRequest $request)
    {
        if($request->isMethod('post')) {
            $failedLogin =  new FailedLogin;
            $failedLogin->logincheck($request->ip());
            $credentials = $request->only('username', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                throw new ApiException(['code'=>11000,'msg'=>'登录成功','data'=>['redirect'=>'/admin/index']]);
            }else{
                $failedLogin->update_failed($request->ip());
            }
        }else{
            $res=['title'=>'后台登录'];
            return view('laravel-admin::admin.login',['res'=>$res]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }


}
