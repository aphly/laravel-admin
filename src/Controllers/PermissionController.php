<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Module;
use Aphly\LaravelAdmin\Models\Permission;
use Aphly\LaravelAdmin\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PermissionController extends Controller
{
    public $index_url='/admin/permission/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        //$res['pid'] = $pid = $request->query('pid',0);
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Permission::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        //->where('pid',$pid)
                        ->orderBy('sort', 'desc')->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
//        $res['parent'] = $this->parentInfo($pid);
//        $res['permission'] = Permission::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-admin::permission.index',['res'=>$res]);
    }


    public function parentInfo($pid)
    {
        $parent = Permission::where('id', '=', $pid)->first();
        return !is_null($parent) ? $parent->toArray() : [];
    }

    public function add(PermissionRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Permission::create($post);
            if($role->id){
                Cache::forget('role_permission');
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title'] = '';
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::permission.add',['res'=>$res]);
        }
    }

    public function edit(PermissionRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Permission::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                Cache::forget('role_permission');
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title'] = '';
            $res['info'] = Permission::find($request->id);
//            $res['pid'] = $pid =  $request->query('pid',0);
//            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::permission.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Permission::where('pid',$post)->get();
            if($data->isEmpty()){
                Permission::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的权限','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function show()
    {
        $data = Permission::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        $res['module'] = (new Module)->getByCache();
        return $this->makeView('laravel-admin::permission.show',['res'=>$res]);
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $pid = $request->input('pid',0);
        if($pid){
            $pInfo = Permission::where('id',$pid)->first();
            if($pInfo){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Permission::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/permission/show']]);
    }
}
