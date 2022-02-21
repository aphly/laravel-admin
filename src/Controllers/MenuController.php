<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Menu;
use Aphly\LaravelAdmin\Requests\MenuRequest;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public $index_url='/admin/menu/index';

    public function index(Request $request)
    {
        $res=['title'=>'我的'];
        $res['filter']['name'] = $name = $request->query('name',false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['data'] = Menu::when($name,
                            function($query,$name) {
                                return $query->where('name', 'like', '%'.$name.'%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return view('laravel-admin::menu.index',['res'=>$res]);
    }

    public function add(MenuRequest $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            $role = Menu::create($post);
            if($role->id){
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res=['title'=>'我的'];
            $res['menu'] = Menu::get()->toArray();
            //$res['menu'] = Helper::getTree($res['menu']);
            //dd($res['menu']);
            return view('laravel-admin::menu.add',['res'=>$res]);
        }
    }

    public function edit(MenuRequest $request)
    {
        if($request->isMethod('post')) {
            $role = Menu::find($request->id);
            $post = $request->all();
            if($role->update($post)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res=['title'=>'我的'];
            //$res['info'] = Menu::find($request->id);
            $res['menu'] = Menu::get()->toArray();
            foreach ($res['menu'] as $v){
                if($v['id']==$request->id){
                    $res['info']=$v;
                }
            }
            return view('laravel-admin::menu.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Menu::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
