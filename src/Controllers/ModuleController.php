<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModuleController extends Controller
{
    public $index_url = '/admin/module/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter']['name'] = $name = $request->query('name', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Module::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('sort', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::module.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['module'] = Module::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::module.form',['res'=>$res]);
    }

    public function install(Request $request)
    {
        $info = Module::where('id',$request->query('id',0))->first();
        if(!empty($info)){
            $status = $request->query('status',0);
            if($status){
                (new $info->classname)->install();
            }else{
                (new $info->classname)->uninstall();
            }
            $info->status=$status;
            $info->save();
        }
        throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['key'] = trim($input['key']);
        Module::updateOrCreate(['id'=>$request->query('id',0)],$input);
        Cache::forget('module');
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Module::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
