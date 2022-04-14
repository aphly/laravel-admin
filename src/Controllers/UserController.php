<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\UploadFile;
use Aphly\Laravel\Models\User;
use Aphly\Laravel\Models\UserAuth;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\UserRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public $index_url='/admin/user/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter']['identifier'] = $identifier = $request->query('identifier',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = User::when($status,
                                function($query,$status) {
                                    return $query->where('status', '=', $status);
                                })
                            ->whereHas('userAuth', function (Builder $query) use ($identifier) {
                                if($identifier){
                                    $query->where('identifier', 'like', '%'.$identifier.'%')
                                        ->where('identity_type', config('laravel.identity_type'));
                                }
                            })->orderBy('created_at', 'desc')->with('userAuth')->Paginate(config('admin.perPage'))->withQueryString();
        $res['role'] = (new Role)->getRoleById(3);
        $res['role'] = array_column($res['role'], null, 'id');
        return $this->makeView('laravel-admin::user.index',['res'=>$res]);
    }

    public function edit(UserRequest $request)
    {
        if($request->isMethod('post')) {
            $user = User::find($request->uuid);
            $post = $request->all();
            if($user->update($post)){
                $post['verified']  = isset($post['verified'])?1:0;
                UserAuth::where(['identity_type'=>'email','uuid'=>$user->uuid])->update(['verified'=>$post['verified']]);
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }
            throw new ApiException(['code'=>1,'msg'=>'修改失败']);
        }else{
            $res['title'] = '';
            $res['info'] = User::where('uuid',$request->uuid)->first();
            return $this->makeView('laravel-admin::user.edit',['res'=>$res]);
        }
    }

    public function password(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            if(!empty($post['credential'])){
                (new UserAuth)->changePassword($request->uuid,$post['credential']);
                throw new ApiException(['code'=>0,'msg'=>'密码修改成功','data'=>['redirect'=>$this->index_url]]);
            }
            throw new ApiException(['code'=>1,'msg'=>'修改失败']);
        }else{
            $res['title'] = '';
            $res['info'] = User::where('uuid',$request->uuid)->first();
            return $this->makeView('laravel-admin::user.password',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            User::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function role(Request $request)
    {
        if($request->isMethod('post')) {
            User::where('uuid',$request->uuid)->update($request->only('role_id'));
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['title'] = '';
            $res['info'] = User::find($request->uuid);
            $res['select_ids'] = [$res['info']['role_id']];
            $res['role'] = (new Role)->getRoleById(3);
            return $this->makeView('laravel-admin::user.role',['res'=>$res]);
        }
    }

    public function avatar(Request $request)
    {
        if($request->isMethod('post')) {
            //$cache = Setting::getCache();
            //$host = $cache['oss_status'] ? $cache['siteurl'] : $cache['oss_host'];
            $file = $request->file('avatar');
            $avatar = UploadFile::upload($file,'public/avatar');
            if ($avatar) {
                $user = User::find($request->uuid);
                $oldAvatar = $user->avatar;
                $user->avatar = $avatar;
                if ($user->save()) {
                    $user->delAvatar($oldAvatar);
                    throw new ApiException(['code'=>0,'msg'=>'上传成功','data'=>['redirect'=>$this->index_url,'avatar'=>Storage::url($avatar)]]);
                } else {
                    throw new ApiException(['code'=>1,'msg'=>'保存错误']);
                }
            }
            throw new ApiException(['code'=>2,'data'=>'','msg'=>'上传错误']);
        }else{
            $res['title'] = '';
            $res['info'] = User::find($request->uuid);
            return $this->makeView('laravel-admin::user.avatar',['res'=>$res]);
        }
    }

}
