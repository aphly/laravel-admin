<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\UploadFile;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    public $index_url = '/admin/upload_file/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['search']['uuid'] = $request->query('uuid', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = UploadFile::when($res['search']['uuid'],
                            function ($query, $uuid) {
                                return $query->where('uuid', $uuid);
                            })
                        ->dataPerm(Manager::_uuid(),$this->roleLevelIds)
                        ->orderBy('id','desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::upload_file.index', ['res' => $res]);
    }

	public function edit(Request $request)
	{
		$res['info'] = UploadFile::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$res['info']->update($request->all());
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
			return $this->makeView('laravel-admin::upload_file.form',['res'=>$res]);
		}
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            UploadFile::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

}
