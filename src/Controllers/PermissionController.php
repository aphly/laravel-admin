<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Module;
use Aphly\Laravel\Models\Permission;
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
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Permission::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        //->where('pid',$pid)
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::permission.index',['res'=>$res]);
    }


    public function add(PermissionRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $permission = Permission::create($post);
			$form_edit = $request->input('form_edit',0);
			if($permission->id){
				Cache::forget('role_permission');
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/admin/permission/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
        }else{
            $res['title'] = '';
			$res['info'] = Permission::where('id',$request->query('id',0))->firstOrNew();
            return $this->makeView('laravel-admin::permission.form',['res'=>$res]);
        }
    }

    public function edit(PermissionRequest $request)
    {
		$res['info'] = Permission::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				Cache::forget('role_permission');
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/admin/permission/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
        }else{
            $res['module'] = (new Module)->getByCache();
            return $this->makeView('laravel-admin::permission.form',['res'=>$res]);
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
            if(!empty($pInfo)){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Permission::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/permission/show']]);
    }
}
