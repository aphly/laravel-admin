<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Func;
use Aphly\Laravel\Models\Dictionary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DictionaryController extends Controller
{
    public $index_url = '/admin/dictionary/index';

    public function index(Request $request)
    {
        $res = ['title' => '我的'];
        $res['pid'] = $pid = $request->query('pid', 0);
        $res['filter']['name'] = $name = $request->query('name', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = Dictionary::when($name,
                            function ($query, $name) {
                                return $query->where('name', 'like', '%' . $name . '%');
                            })
                        ->orderBy('sort', 'desc')
                        ->where('pid',$pid)
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['parent'] = $this->parentInfo($pid);
        return $this->makeView('laravel-admin::dictionary.index', ['res' => $res]);
    }

    public function parentInfo($pid)
    {
        $parent = Dictionary::where('id', '=', $pid)->first();
        return !is_null($parent) ? $parent->toArray() : [];
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')) {
            $post = $request->all();
            if(isset($post['json'])){
                foreach ($post['json'] as $k=>$v){
                    $post['json'][$k] = $v;
                    $post['json'][$k]['sort'] = intval($v['sort']);
                }
                $post['json'] = json_encode($post['json']);
            }
            $role = Dictionary::create($post);
            if($role->id){
                Cache::forget('role_menu');
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['title']='我的';
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::dictionary.add',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        if($request->isMethod('post')) {
            $role = Dictionary::find($request->id);
            $post = $request->all();
            if(isset($post['json'])){
                $post['json'] = json_encode($post['json']);
            }
            if($role->update($post)){
                Cache::forget('role_menu');
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url($post)]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            $res['title']='我的';
            $res['info'] = Dictionary::find($request->id);
            $res['info']['json'] = json_decode($res['info']['json'],true);
            $res['info']['json'] = Func::array_orderby($res['info']['json'],'sort',SORT_DESC);
            $res['pid'] = $pid =  $request->query('pid',0);
            $res['parent'] = $this->parentInfo($pid);
            return $this->makeView('laravel-admin::dictionary.edit',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Dictionary::where('pid',$post)->get();
            if($data->isEmpty()){
                Dictionary::destroy($post);
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除目录内的菜单','data'=>['redirect'=>$redirect]]);
            }
        }
    }

    public function show(Request $request)
    {
        $res['menu_show'] = (new Dictionary)->getMenuById($request->id);
        return $this->makeView('laravel-admin::dictionary.show',['res'=>$res]);
    }
}
