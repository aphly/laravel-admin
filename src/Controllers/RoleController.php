<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Permission;
use Aphly\LaravelAdmin\Models\Role;
use Aphly\LaravelAdmin\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleController extends Controller
{
    public $index_url='/admin/role/index';

    public function index(Request $request)
    {
        $res=['title'=>'我的'];
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Role::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return view('laravel-admin::role.index',['res'=>$res]);
    }

    public function add(RoleRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Role::create($post);
            if($role->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res=['title'=>'我的'];
            return view('laravel-admin::role.add',['res'=>$res]);
        }
    }

    public function edit(RoleRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Role::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res=['title'=>'我的'];
            $res['info'] = Role::find($request->id);
            return view('laravel-admin::role.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Role::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function permission(Request $request)
    {
        if($request->isMethod('post')) {
            $role = Role::find($request->id);
            if($role){
                $role->permission()->sync($request->input('permission_id'));
            }
            Cache::forget('role_permission');
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res=['title'=>'我的'];
            $res['info'] = Role::find($request->id);
            $res['role_permission'] = $res['info']->permission->toArray();
            $res['role_permission'] = array_column($res['role_permission'], 'id');
            $res['permission'] = Permission::get()->toArray();
            return view('laravel-admin::role.permission',['res'=>$res]);
        }
    }


}
