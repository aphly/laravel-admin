<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Menu;
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
        $res['title']='我的';
        $res['pid'] = $pid = $request->query('pid', 0);
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Role::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        ->where('pid',$pid)
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['parent'] = $this->parentInfo($pid);
        return $this->makeView('laravel-admin::role.index',['res'=>$res]);
    }

    public function parentInfo($pid)
    {
        $parent = Role::where('id', '=', $pid)->first();
        return !is_null($parent) ? $parent->toArray() : [];
    }

    public function add(RoleRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Role::create($post);
            if($role->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title']='我的';
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::role.add',['res'=>$res]);
        }
    }

    public function edit(RoleRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Role::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title']='我的';
            $res['info'] = Role::find($request->id);
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::role.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Role::where('pid',$post)->get();
            if($data->isEmpty()){
                Role::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function show(Request $request)
    {
        $res['role'] = Role::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        $res['role_tree'] = Helper::getTree($res['role'],true);
        Helper::getTreeByid($res['role_tree'],$request->id,$res['role_tree']);
        Helper::TreeToArr([$res['role_tree']],$res['role_show']);
        return $this->makeView('laravel-admin::role.show',['res'=>$res]);
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
            $res['title']='我的';
            $res['info'] = Role::find($request->id);
            $res['role_permission'] = $res['info']->permission->toArray();
            $res['select_ids'] = array_column($res['role_permission'], 'id');
            $res['permission'] = Permission::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
            return $this->makeView('laravel-admin::role.permission',['res'=>$res]);
        }
    }

    public function menu(Request $request)
    {
        if($request->isMethod('post')) {
            $role = Role::find($request->id);
            if($role){
                $role->menu()->sync($request->input('menu_id'));
            }
            Cache::forget('role_menu');
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['title']='我的';
            $res['info'] = Role::find($request->id);
            $res['role_menu'] = $res['info']->menu->toArray();
            $res['select_ids'] = array_column($res['role_menu'], 'id');
            $res['menu'] = Menu::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
            return $this->makeView('laravel-admin::role.menu',['res'=>$res]);
        }
    }
}
