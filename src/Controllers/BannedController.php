<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Banned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannedController extends Controller
{
    public $index_url = '/admin/banned/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['ip'] = $ip = $request->query('ip', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Banned::when($ip,
                            function ($query, $ip) {
                                return $query->where('ip', 'like', '%' . $ip . '%');
                            })
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::banned.index', ['res' => $res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')){
			$input = $request->all();
			$input['uuid'] = $this->manager->uuid;
			Banned::create($input);
			throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
		}else{
			$res['info'] = Banned::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::banned.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Banned::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$res['info']->update($request->all());
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
			return $this->makeView('laravel-admin::banned.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['info'] = Banned::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::banned.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['uuid'] = $this->manager->uuid;
        Banned::updateOrCreate(['id'=>$request->query('id',0)],$input);
        Cache::forget('banned');
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Banned::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function banned(Request $request)
    {
        $res['title'] = 'Banned';
        return $this->makeView('laravel-admin::banned.banned',['res'=>$res]);
    }
}
