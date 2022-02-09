<?php

namespace Aphly\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $post = $request->input('delete');
            User::destroy($post);
            return redirect()->route('admin.user')->with('status', 'success');
        }else{
            $res=['title'=>'我的'];
            //$res['user']=Auth::user();

            $res['data'] = User::Paginate(config('G.perPage'));
            return view('admin.user.index',['res'=>$res]);
        }
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $user = new User;
            $post = $user->admincheck($request,'doadd');
            $user->username = $post['username'];
            if($post['nickname']){
                $user->nickname = $post['nickname'];
            }
            if($post['email']){
                $user->email = $post['email'];
            }
            if($post['phone']){
                $user->phone = $post['phone'];
            }
            $user->password = Hash::make($post['password']);
            if($user->save()){
                return redirect()->route('admin.user')->with('status', 'success');
            }else{
                return back()->with('status', 'fail');
            }
        }else{
            $res=['title'=>'我的'];
            //$res['user']=Auth::user();
            return view('admin.user.add',['res'=>$res]);
        }

    }

    public function edit(Request $request)
    {
        if($request->isMethod('post')) {
            $user = User::find($request->id);
            $post = $user->admincheck($request,'doedit');
            if($post['username']){
                $user->username = $post['username'];
            }
            if($post['nickname']){
                $user->nickname = $post['nickname'];
            }
            if($post['nickname']){
                $user->email = $post['email'];
            }
            if($post['phone']){
                $user->phone = $post['phone'];
            }
            if($post['password']){
                $user->password = Hash::make($post['password']);
            }
            if($user->save()){
                return redirect()->route('admin.user')->with('status', 'success');
            }else{
                return back()->with('status', 'fail');
            }
        }else{
            $res=['title'=>'我的'];
            $res['user']=Auth::user();
            $res['info'] = User::find($request->id);
            return view('admin.user.edit',['res'=>$res]);
        }
    }

    public function role(Request $request)
    {
        if($request->isMethod('post')) {
            $userrole = new UserRole;
            $user = User::find($request->id);
            if($user){
                if($user->role()->sync($request->input('role_id'))){
                    return redirect()->route('admin.user')->with('status', 'success');
                }
            }
            return back()->with('status', 'fail');
        }else{
            $res=['title'=>'我的'];
            //$res['user']=Auth::user();
            $res['info'] = User::find($request->id);
            $res['userrole'] = $res['info']->role->toArray();
            $res['userrole'] = array_column($res['userrole'], 'id');
            $res['role'] = Role::all()->toArray();
            return view('admin.user.role',['res'=>$res]);
        }

    }

    public function avatar(Request $request)
    {
        if($request->isMethod('post')) {
            //$cache = Setting::getCache();
            //$host = $cache['oss_status'] ? $cache['siteurl'] : $cache['oss_host'];
            $file = $request->file('avatar');
            $avatar = Common::uploadFile($file,'avatar','avatar');
            if ($avatar) {
                $user = User::find($request->id);
                $oldavatar = $user->avatar;
                $user->avatar = $avatar;
                if ($user->save()) {
                    $user->delAvatar($oldavatar);
                    return redirect()->route('admin.user')->with('status', 'success');
                } else {
                    throw ValidationException::withMessages([
                        'avatar' =>'保存错误',
                    ]);
                }
            }
            throw ValidationException::withMessages([
                'avatar' =>'上传错误',
            ]);
        }else{
            $res=['title'=>'我的'];
            $res['info'] = User::find($request->id);
            return view('admin.user.avatar',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return redirect()->route('admin.user')->with('status', 'success');
    }


}
