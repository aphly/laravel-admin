<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Config;
use Aphly\Laravel\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    public $index_url = '/admin/config/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Config::when($res['search']['name'],
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::config.index', ['res' => $res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')){
			$input = $request->all();
			$input['type'] = trim($input['type']);
			$input['key'] = trim($input['key']);
			Config::create($input);
			Cache::forget('admin_config');
			throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
		}else{
			$res['info'] = Config::where('id',$request->query('id',0))->firstOrNew();
			$res['module'] = (new Module)->getByCache();
			return $this->makeView('laravel-admin::config.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Config::where('id',$request->query('id',0))->firstOrError();
		$res['module'] = (new Module)->getByCache();
		if($request->isMethod('post')){
			$input = $request->all();
			$input['type'] = trim($input['type']);
			$input['key'] = trim($input['key']);
			$res['info']->update($input);
			Cache::forget('admin_config');
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
			return $this->makeView('laravel-admin::config.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['setting'] = Config::where('id',$request->query('id',0))->firstOrNew();

        return $this->makeView('laravel-admin::config.form',['res'=>$res]);
    }

    public function save(Request $request){
        (new Config)->saveInput($request);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Config::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
