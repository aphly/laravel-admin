<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Module;
use Aphly\Laravel\Models\Api;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $index_url='/admin/api/index';

    private $currArr = ['name'=>'接口','key'=>'api'];

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['name'] = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Api::when($res['search']['name'],
            function($query,$name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->with('module')
            ->orderBy('id', 'desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::api.index',['res'=>$res]);
    }


    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            if($post['pid']){
                $parent = Api::where('id',$post['pid'])->first();
                if(!empty($parent) && $parent->status==2){
                    $post['status'] = $parent->status;
                }
            }
            $api = Api::create($post);
            $form_edit = $request->input('form_edit',0);
            if($api->id){
                //Cache::forget('role_api');
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/api/tree']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
            }
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
            $res['info'] = Api::where('id',$request->query('id',0))->firstOrNew();
            $res['rbacRoutes'] = $this->getRoutes('rbac');
            return $this->makeView('laravel-admin::api.form',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        $res['info'] = Api::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $post = $request->all();
            $form_edit = $request->input('form_edit',0);
            if($res['info']->update($post)){
                if($post['status']==2){
                    $res['info']->closeChildStatus($res['info']->id);
                }
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/api/tree']]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
            }
        }else{
            $res['module'] = (new Module)->getByCache();
            $res['rbacRoutes'] = $this->getRoutes('rbac');
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
            return $this->makeView('laravel-admin::api.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Api::where('pid',$post)->get();
            if($data->isEmpty()){
                Api::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的权限','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function tree()
    {
        $res['list'] = Api::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['module'] = (new Module)->getByCache();
        $res['rbacRoutes'] = $this->getRoutes('rbac');
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/admin/'.$this->currArr['key'].'/tree']
        ]);
        return $this->makeView('laravel-admin::api.tree',['res'=>$res]);
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $pid = $request->input('pid',0);
        if($pid){
            $pInfo = Api::where('id',$pid)->first();
            if(!empty($pInfo)){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Api::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/api/tree']]);
    }
}
