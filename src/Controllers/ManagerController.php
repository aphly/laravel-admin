<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Manager;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\ManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerController extends Controller
{

    public function index(Request $request)
    {
        $res=['title'=>'我的'];
        $res['filter']['username'] = $username = $request->query('username',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Manager::when($username,
                    function($query,$username) {
                        return $query->where('username', 'like', '%'.$username.'%');
                    }
                )->when($status,
                    function($query,$status) {
                        return $query->where('status', '=', $status);
                    })
                ->Paginate(config('admin.perPage'))->withQueryString();
        return view('laravel-admin::manager.index',['res'=>$res]);
    }

    public function add(ManagerRequest $request)
    {
        if($request->isMethod('post')){
            $post = $request->all();
            $post['uuid'] = $post['token'] = Helper::uuid();
            $post['token_expire'] = time();
            $post['password'] = Hash::make($post['password']);
            $manager = Manager::create($post);
            if($manager->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>'/admin/manager/index']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res=['title'=>'我的'];
            return view('laravel-admin::manager.add',['res'=>$res]);
        }
    }

    public function edit(ManagerRequest $request)
    {
        if($request->isMethod('post')) {
            $manager = Manager::find($request->id);
            $post = $request->all();
            if(!empty($post['password'])){
                $post['password'] = Hash::make($post['password']);
            }else{
                unset($post['password']);
            }
            if($manager->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>'/admin/manager/index']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res=['title'=>'我的'];
            $res['info'] = Manager::find($request->id);
            return view('laravel-admin::manager.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?'/admin/manager/index?'.http_build_query($query):'/admin/manager/index';
        $post = $request->input('delete');
        if(!empty($post)){
            Manager::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function role(Request $request)
    {
        if($request->isMethod('post')) {
            //$userrole = new RbacUserRole;
            $user = Manager::find($request->id);
            if($user){
                if($user->role()->sync($request->input('role_id'))){
                    throw new ApiException(['code'=>10000,'msg'=>'删除成功']);
                    return redirect()->route('admin.user')->with('status', 'success');
                }
            }
            throw new ApiException(['code'=>10000,'msg'=>'删除成功']);
        }else{
            $res=['title'=>'我的'];
            $res['info'] = Manager::find($request->id);
            $res['userrole'] = $res['info']->role->toArray();
            $res['userrole'] = array_column($res['userrole'], 'id');
            $res['role'] = Role::all()->toArray();
            return view('laravel-admin::manager.role',['res'=>$res]);
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

}
