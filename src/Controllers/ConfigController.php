<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Config;
use Aphly\LaravelAdmin\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigController extends Controller
{
    public $index_url = '/admin/config/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name', false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Config::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::config.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['setting'] = Config::where('id',$request->query('id',0))->firstOrNew();
        $res['module'] = (new Module)->getByCache();
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