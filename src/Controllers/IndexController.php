<?php

namespace Aphly\LaravelAdmin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    public function layout()
    {
        $res=['title'=>'我的'];
        $res['user']=Auth::user();
        return view('admin.layout',['res'=>$res]);
    }

    public function index()
    {
        $res=['title'=>'我的'];
        //$res['user']=Auth::user();
        return view('admin.index.index',['res'=>$res]);
    }

    public function login(Request $request)
    {
        if($request->isMethod('post')) {
            if(!FailedLogin::logincheck($request->ip())){
                throw ValidationException::withMessages([
                    'failedlogin' =>'密码错误超过'.FailedLogin::LIMITTIMES.'次数，请15分钟后再试',
                ]);
            }
            $request->old('username');
            $userModel = new User;
            $post = $userModel->admincheck($request,'login');
            $user = $userModel->where('username', $post['username'])->first();
            if($user){
                if(Hash::check($post['password'],$user['password'])){
                    Auth::login($user);
                    return redirect('/admin/index');
                }else{
                    $times = FailedLogin::update_failed($request->ip());
                    $msg = $times>0?'密码错误，还有'.$times.'次尝试机会':'密码错误，请等待15分钟再试';
                    throw ValidationException::withMessages([
                        'password' =>$msg,
                    ]);
                }
            }else{
                throw ValidationException::withMessages([
                    'username' =>'用户不存在',
                ]);
            }
        }else{
            $res=['title'=>'后台登录'];
            return view('admin.user.login',['res'=>$res]);
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
