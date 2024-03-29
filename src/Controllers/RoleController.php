<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Level;
use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module;
use Aphly\Laravel\Models\Api;
use Aphly\Laravel\Models\Role;
use Aphly\Laravel\Models\RoleMenu;
use Aphly\Laravel\Models\RoleApi;
use Aphly\LaravelAdmin\Requests\RoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $index_url='/admin/role/index';

    private $currArr = ['name'=>'角色','key'=>'role'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Role::when($res['search'],
                        function ($query, $search) {
                            if($search['name']!==''){
                                $query->where('name', 'like', '%' . $search['name'] . '%');
                            }
                        })
                        ->with('module')
                        ->orderBy('sort', 'desc')->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['levelList'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::role.index',['res'=>$res]);
    }

    public function add(RoleRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $post['uuid'] = $this->manager->uuid;
            $role = Role::create($post);
			$form_edit = $request->input('form_edit',0);
			if($role->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/role/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
        }else{
			$res['info'] = Role::where('id',$request->query('id',0))->firstOrNew();
            $res['module'] = (new Module)->getByCache();
            $res['levelList'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
            return $this->makeView('laravel-admin::role.form',['res'=>$res]);
        }
    }

    public function edit(RoleRequest $request)
    {
		$res['info'] = Role::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $post = $request->all();
			$form_edit = $request->input('form_edit',0);
            if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/role/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
        }else{
            $res['module'] = (new Module)->getByCache();
            $res['levelList'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
            return $this->makeView('laravel-admin::role.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Role::where('pid',$post)->get();
            if($data->isEmpty()){
                Role::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的角色','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $pid = $request->input('pid',0);
        if($pid){
            $pInfo = Role::where('id',$pid)->first();
            if(!empty($pInfo)){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Role::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/role/tree']]);
    }

    public function menu(Request $request)
    {
        $res['info'] = Role::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $res['info']->menu()->sync($request->input('menu_id'));
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['role_menu'] = RoleMenu::where(['role_id'=>$res['info']->id])->get()->toArray();
            $res['select_ids'] = array_column($res['role_menu'], 'menu_id');
            $res['list'] = Menu::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'菜单','href'=>'/admin/'.$this->currArr['key'].'/menu?id='.$res['info']->id]
            ]);
            return $this->makeView('laravel-admin::role.menu',['res'=>$res]);
        }
    }

    public function api(Request $request)
    {
        $res['info'] = Role::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')) {
            $res['info']->api()->sync($request->input('api_id'));
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['role_api'] = RoleApi::where(['role_id'=>$res['info']->id])->get()->toArray();
            $res['select_ids'] = array_column($res['role_api'], 'api_id');
            $res['list'] = Api::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'接口','href'=>'/admin/'.$this->currArr['key'].'/api?id='.$res['info']->id]
            ]);
            return $this->makeView('laravel-admin::role.api',['res'=>$res]);
        }
    }
}
