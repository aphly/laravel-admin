<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Manager;
use Aphly\LaravelAdmin\Models\Permission;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\ManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ManagerController extends Controller
{
    public $index_url='/admin/manager/index';

    public function index(Request $request)
    {
        $res['title']='';
        $res['filter']['username'] = $username = $request->query('username',false);
        $res['filter']['status'] = $status = $request->query('status',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Manager::when($username,
                            function($query,$username) {
                                return $query->where('username', 'like', '%'.$username.'%');
                            })
                        ->when($status,
                            function($query,$status) {
                                return $query->where('status', '=', $status);
                            })
                        ->with('role')
                        ->orderBy('uuid', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::manager.index',['res'=>$res]);
    }

    public function add(ManagerRequest $request)
    {
        if($request->isMethod('post')){
            $post = $request->all();
            $post['uuid'] = $post['token'] = Helper::uuid();
            $post['token_expire'] = time();
            $post['password'] = Hash::make($post['password']);
            $manager = Manager::create($post);
            if($manager->uuid){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title']='';
            return $this->makeView('laravel-admin::manager.add',['res'=>$res]);
        }
    }

    public function edit(ManagerRequest $request)
    {
        if($request->isMethod('post')) {
            $manager = Manager::find($request->uuid);
            $post = $request->all();
            if(!empty($post['password'])){
                $post['password'] = Hash::make($post['password']);
            }else{
                unset($post['password']);
            }
            if($manager->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['info'] = Manager::find($request->uuid);
            return $this->makeView('laravel-admin::manager.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Manager::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function role(Request $request)
    {
        if($request->isMethod('post')) {
            $manager = Manager::find($request->uuid);
            if($manager){
                $manager->role()->sync($request->input('role_id'));
            }
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['info'] = Manager::find($request->uuid);
            $res['user_role'] = $res['info']->role->toArray();
            $res['select_ids'] = array_column($res['user_role'], 'id');
            $res['role'] = Role::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
            return $this->makeView('laravel-admin::manager.role',['res'=>$res]);
        }
    }


}
