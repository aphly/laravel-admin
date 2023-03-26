<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\FailedLogin;
use Illuminate\Http\Request;

class FailedLoginController extends Controller
{
    public $index_url = '/admin/failed_login/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['ip'] = $ip = $request->query('ip', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = FailedLogin::when($ip,
                            function ($query, $ip) {
                                return $query->where('ip', 'like', '%' . $ip . '%');
                            })
                        ->orderBy('id','desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::failed_login.index', ['res' => $res]);
    }



	public function edit(Request $request)
	{
		$res['info'] = FailedLogin::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$res['info']->update($request->all());
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
			return $this->makeView('laravel-admin::failed_login.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['info'] = FailedLogin::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::failed_login.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['uuid'] = $this->manager->uuid;
        FailedLogin::updateOrCreate(['id'=>$request->query('id',0)],$input);
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            FailedLogin::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
