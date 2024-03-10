<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Controllers\Admin\Controller;
use Aphly\Laravel\Models\Links;
use Illuminate\Http\Request;

class LinksController extends Controller
{
    public $index_url='/admin/links/index';

    private $currArr = ['name'=>'链接','key'=>'links'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Links::when($res['search'],
            function($query,$search) {
                if($search['name']!==''){
                    $query->where('name', 'like', '%'.$search['name'].'%');
                }
            })
            ->orderBy('sort','desc')
            ->Paginate(config('base.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::links.index',['res'=>$res]);
    }

    public function tree()
    {
        $res['list'] = Links::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/admin/links/tree']
        ]);
        return $this->makeView('laravel-admin::links.tree',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        Links::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0),],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>'/admin/links/tree']]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = Links::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/admin/links/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = Links::where('id',$request->query('id',0))->firstOrNew();

			return $this->makeView('laravel-admin::links.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Links::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/admin/links/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/links/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::links.form',['res'=>$res]);
		}
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Links::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }


}
