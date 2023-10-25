<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ModuleController extends Controller
{
    public $index_url = '/admin/module/index';

    private $currArr = ['name'=>'模块','key'=>'module'];

    function getAphly(){
        $aphly = [];
        $providers = config('app.providers');
        foreach($providers as $provider){
            if(preg_match('/^Aphly\\\\/',$provider) && !preg_match('/^Aphly\\\\Laravel\\\\/',$provider) && !preg_match('/^Aphly\\\\LaravelAdmin\\\\/',$provider)){
                $r = strrchr($provider, '\\');
                $aphly[] = str_replace($r,'',$provider);
            }
        }
        return $aphly;
    }

    public function index(Request $request)
    {
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        $res['search']['name'] = $request->query('name', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Module::when($res['search'],
                            function ($query, $search) {
                                if($search['name']!==''){
                                    $query->where('name', 'like', '%' . $search['name'] . '%');
                                }
                            })
                        ->orderBy('sort', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $aphly = $this->getAphly();
        $module = Module::get()->pluck('classname')->all();
        $res['unimport'] = [];
        foreach ($aphly as $val){
            if(!in_array($val,$module)){
                $res['unimport'][] = $val;
            }
        }
        return $this->makeView('laravel-admin::module.index', ['res' => $res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')){
			$input = $request->all();
			$input['key'] = trim($input['key']);
			Module::create($input);
			Cache::forget('module');
			throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
			$res['info'] = Module::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::module.form',['res'=>$res]);
		}
	}

    public function import(Request $request)
    {
        $input = $request->all();
        if(!empty($input['class'])){
            Module::create([
                'name'=>str_replace('Aphly\Laravel','',$input['class']),
                'classname'=>$input['class'],
                'status'=>0,
            ]);
            Cache::forget('module');
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }
        throw new ApiException(['code'=>1,'msg'=>'fail','data'=>['redirect'=>$this->index_url]]);
    }

	public function edit(Request $request)
	{
		$res['info'] = Module::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')){
			$input = $request->all();
			$res['info']->update($input);
			Cache::forget('module');
			throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::module.form',['res'=>$res]);
		}
	}

    public function form(Request $request)
    {
        $res['module'] = Module::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::module.form',['res'=>$res]);
    }

	public function save(Request $request){
		$input = $request->all();
		$input['key'] = trim($input['key']);
		Module::updateOrCreate(['id'=>$request->query('id',0)],$input);
		Cache::forget('module');
		throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
	}

    public function install(Request $request)
    {
        $info = Module::where('id',$request->query('id',0))->first();
        if(!empty($info)){
            $classname = '\\'.$info->classname.'\Models\Module';
            if(class_exists($classname)){
                $status = $request->query('status',0);
                try{
                    if($status){
                        (new $classname)->install($info->id);
                    }else{
                        (new $classname)->uninstall($info->id);
                    }
                }catch (\Exception $e){
                    throw new ApiException(['code'=>0,'msg'=>$e->getMessage(),'data'=>['redirect'=>$this->index_url]]);
                }
                $info->status=$status;
                $info->save();
            }
        }
        throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Module::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
