<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Permission;
use Aphly\LaravelAdmin\Requests\PermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public $index_url='/admin/permission/index';

    public function index(Request $request)
    {
        $res=['title'=>'我的'];
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Permission::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        ->where('pid','=',0)
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return view('laravel-admin::permission.index',['res'=>$res]);
    }

    public function add(PermissionRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Permission::create($post);
            if($role->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res=['title'=>'我的'];
            return view('laravel-admin::permission.add',['res'=>$res]);
        }
    }

    public function edit(PermissionRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Permission::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res=['title'=>'我的'];
            $res['info'] = Permission::find($request->id);
            return view('laravel-admin::permission.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Permission::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
