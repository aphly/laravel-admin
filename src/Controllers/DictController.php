<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Dict;
use Aphly\Laravel\Models\DictValue;
use Aphly\Laravel\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DictController extends Controller
{
    public $index_url = '/admin/dict/index';

    private $currArr = ['name'=>'字典','key'=>'dict'];

    public function index(Request $request)
    {
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        $res['search']['name'] =  $request->query('name', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Dict::when($res['search'],
                            function ($query, $search) {
                                if($search['name']!==''){
                                    $query->where('name', 'like', '%' . $search['name'] . '%');
                                }
                            })
                        ->with('module')
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::dict.index', ['res' => $res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')){

			$this->save($request);
		}else{
			$res['info'] = Dict::where('id',$request->query('id',0))->firstOrNew();
			$res['dictValue'] = [];
			$res['module'] = (new Module)->getByCache();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
			return $this->makeView('laravel-admin::dict.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		if($request->isMethod('post')){
			$this->save($request);
		}else{
			$res['dictValue'] = [];
			$res['info'] = Dict::where('id',$request->query('id',0))->firstOrError();
            $res['dictValue'] = DictValue::where('dict_id',$res['info']->id)->orderBy('sort','desc')->get();
            $res['module'] = (new Module)->getByCache();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::dict.form',['res'=>$res]);
		}
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

    public function save($request){
        $input = $request->all();
        $input['key'] = trim($input['key']);
        $input['uuid'] = $this->manager->uuid;
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
            DictValue::upsert($update_arr,['id'],['dict_id','name','value','sort']);
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
