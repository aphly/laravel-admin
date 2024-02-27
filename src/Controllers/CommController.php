<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Comm;
use Aphly\Laravel\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommController extends Controller
{
    public $index_url = '/admin/comm/index';

    private $currArr = ['name'=>'通信','key'=>'app'];

    public function index(Request $request)
    {
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        $res['search']['name'] = $request->query('name', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Comm::when($res['search'],
                            function ($query, $search) {
                                if($search['name']!==''){
                                    $query->where('name', 'like', '%' . $search['name'] . '%');
                                }
                            })
                        ->orderBy('sort', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::comm.index', ['res' => $res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')){
			$input = $request->all();
			Comm::create($input);
			throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
			$res['info'] = Comm::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::comm.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Comm::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$input = $request->all();
			$res['info']->update($input);
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::comm.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['app'] = Comm::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::comm.form',['res'=>$res]);
    }

	public function save(Request $request){
		$input = $request->all();
		Comm::updateOrCreate(['id'=>$request->query('id',0)],$input);
		throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $info = Module::where('app_id',$post)->first();
            if(!in_array(1,$post) && !$info){
                Comm::whereIn('id',$post)->delete();
            }
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function sign($info){
        $sign = md5(md5($info->id.$info->host.$info->auth_key));
        return $sign;
    }

    public function module(Request $request){
        $res['search']['name'] = $request->query('name', '');
        $res['search']['string'] = http_build_query($request->query());
        $comm_id = $request->query('id', 0);
        $res['info'] = Comm::where('id',$comm_id)->firstOrError();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>$res['info']->name,'href'=>'/admin/comm/module?id='.$comm_id]
        ]);
        $res['sign'] = $this->sign($res['info']);
        $response = Http::get($res['info']->host.'/comm/module?comm_id='.$res['info']->id.'&sign='.$res['sign']);
        if(!$response['code']){
            return $this->makeView('laravel-admin::comm.module', ['res' => array_merge($res,$response['data'])]);
        }else{
            throw new ApiException(['code'=>1,'msg'=>'通信异常 '.$response['msg']]);
        }
    }


}
