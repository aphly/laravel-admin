<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Dict;
use Aphly\LaravelAdmin\Models\DictValue;
use Aphly\LaravelAdmin\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DictController extends Controller
{
    public $index_url = '/admin/dict/index';

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter']['name'] = $name = $request->query('name', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Dict::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('sort', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::dict.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['dictValue'] = [];
        $res['dict'] = Dict::where('id',$request->query('id',0))->firstOrNew();
        if($res['dict']->id){
            $res['dictValue'] = DictValue::where('dict_id',$res['dict']->id)->orderBy('sort','desc')->get();
        }
        $res['module'] = (new Module)->getByCache();
        return $this->makeView('laravel-admin::dict.form',['res'=>$res]);
    }

    public function save(Request $request){
        $input = $request->all();
        $input['key'] = trim($input['key']);
        $dict = Dict::updateOrCreate(['id'=>$request->query('id',0)],$input);
        if($dict->id){
            $dictValue = DictValue::where('dict_id',$dict->id)->pluck('id')->toArray();
            $val_arr = $request->input('value',[]);
            $val_arr_keys = array_keys($val_arr);
            $update_arr = $delete_arr = [];
            foreach ($dictValue as $val){
                if(!in_array($val,$val_arr_keys)){
                    $delete_arr[] = $val;
                }
            }
            DictValue::whereIn('id',$delete_arr)->delete();
            foreach ($val_arr as $key=>$val){
                foreach ($val as $k=>$v){
                    $update_arr[$key][$k]=$v;
                }
                $update_arr[$key]['id'] = intval($key);
                $update_arr[$key]['dict_id'] = $dict->id;
            }
            DictValue::upsert($update_arr,['id'],['dict_id','name','value','fixed','sort']);
        }
        Cache::forget('dict');
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Dict::whereIn('id',$post)->delete();
            DictValue::whereIn('dict_id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
