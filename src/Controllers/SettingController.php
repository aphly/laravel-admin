<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Setting;
use Aphly\LaravelAdmin\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public $index_url = '/admin/setting/index';

    public function index(Request $request)
    {
        $res['filter']['name'] = $name = $request->query('name', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Setting::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::setting.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['setting'] = Setting::where('id',$request->query('id',0))->firstOrNew();
        $res['module'] = (new Module)->getByCache();
        return $this->makeView('laravel-admin::setting.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['key'] = trim($input['key']);
        $input['code'] = trim($input['code']);
        Setting::updateOrCreate(['id'=>$request->query('id',0)],$input);
        Cache::forget('setting');
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Setting::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
