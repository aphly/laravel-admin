<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelAdmin\Models\Module;
use Aphly\LaravelAdmin\Requests\MenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public $index_url = '/admin/menu/index';

    public function index(Request $request)
    {
        $res = ['title' => '我的'];
        $res['filter']['name'] = $name = $request->query('name', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Menu::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::menu.index', ['res' => $res]);
    }

    public function parentInfo($pid)
    {
        $parent = Menu::where('id', '=', $pid)->first();
        return !is_null($parent) ? $parent->toArray() : [];
    }

    public function add(MenuRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Menu::create($post);
            if($role->id){
                Cache::forget('role_menu');
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title'] = '';
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::menu.add',['res'=>$res]);
        }
    }

    public function edit(MenuRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Menu::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                Cache::forget('role_menu');
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title'] = '';
            $res['info'] = Menu::find($request->id);
            $res['module'] = (new Module)->getByCache();
            return $this->makeView('laravel-admin::menu.edit',['res'=>$res]);
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

    public function show()
    {
        $data = Menu::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        $res['module'] = (new Module)->getByCache();
        return $this->makeView('laravel-admin::menu.show',['res'=>$res]);
    }

    public function save(Request $request)
    {
        $input = $request->all();
        $pid = $request->input('pid',0);
        if($pid){
            $pInfo = Menu::where('id',$pid)->first();
            if($pInfo){
                $input['module_id'] = $pInfo->module_id;
            }
        }
        Menu::updateOrCreate(['id'=>$request->query('id',0),'pid'=>$pid],$input);
        throw new ApiException(['code'=>0,'msg'=>'成功','data'=>['redirect'=>'/admin/menu/show']]);
    }

}
