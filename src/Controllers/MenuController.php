<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module;
use Aphly\LaravelAdmin\Requests\MenuRequest;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public $index_url = '/admin/menu/index';

    private $currArr = ['name'=>'菜单','key'=>'menu'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Menu::when($res['search'],
                            function ($query, $search) {
                                if($search['name']!==''){
                                    $query->where('name', 'like', '%' . $search['name'] . '%');
                                }
                            })
                        ->with('module')
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::menu.index', ['res' => $res]);
    }

    public function add(MenuRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $post['uuid'] = $this->manager->uuid;
            if($post['pid']){
                $parent = Menu::where('id',$post['pid'])->first();
                if(!empty($parent) && $parent->status==2){
                    $post['status'] = $parent->status;
                }
            }
            $menu = Menu::create($post);
			$form_edit = $request->input('form_edit',0);
			if($menu->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/menu/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
			$res['info'] = Menu::where('id',$request->query('id',0))->firstOrNew();
            return $this->makeView('laravel-admin::menu.form',['res'=>$res]);
        }
    }

    public function edit(MenuRequest $request)
    {
		$res['info'] = Menu::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
                if($post['status']==2){
                    $res['info']->closeChildStatus($res['info']->id);
                }
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/'.$this->currArr['key'].'/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
            $res['module'] = (new Module)->getByCache();
            $res['allRoutes'] = $this->getRoutes();
            return $this->makeView('laravel-admin::menu.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Menu::where('pid',$post)->get();
            if($data->isEmpty()){
                Menu::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function tree()
    {
        $res['list'] = Menu::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['module'] = (new Module)->getByCache();
        $res['allRoutes'] = $this->getRoutes();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/admin/'.$this->currArr['key'].'/tree']
        ]);
        return $this->makeView('laravel-admin::menu.tree',['res'=>$res]);
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $pid = $request->input('pid',0);
        if($pid){
            $pInfo = Menu::where('id',$pid)->first();
            if(!empty($pInfo)){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Menu::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/'.$this->currArr['key'].'/tree']]);
    }

}
