<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\FailedLogin;
use Illuminate\Http\Request;

class FailedLoginController extends Controller
{
    public $index_url = '/admin/failed_login/index';

    private $currArr = ['name'=>'错误登录','key'=>'failed_login'];

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['ip'] =  $request->query('ip', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = FailedLogin::when($res['search'],
                            function ($query, $search) {
                                if($search['ip']!==''){
                                    $query->where('ip', 'like', '%' .$search['ip'] . '%');
                                }
                            })
                        ->orderBy('id','desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::failed_login.index', ['res' => $res]);
    }

	public function edit(Request $request)
	{
		$res['info'] = FailedLogin::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$res['info']->update($request->all());
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'],'href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::failed_login.form',['res'=>$res]);
		}
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
