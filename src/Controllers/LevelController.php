<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Level;
use Aphly\Laravel\Models\LevelPath;
use Aphly\Laravel\Models\Module;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public $index_url='/admin/level/index';

    private $currArr = ['name'=>'层级','key'=>'level'];

    public function index(Request $request)
    {
        $res['search']['name'] = $request->query('name','');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = LevelPath::leftJoin('admin_level as c1','c1.id','=','admin_level_path.level_id')
            ->leftJoin('admin_level as c2','c2.id','=','admin_level_path.path_id')
            ->when($res['search'],
                function($query,$search) {
                    if($search['name']!==''){
                        $query->where('c1.name', 'like', '%'.$search['name'].'%');
                    }
                })
            ->groupBy('level_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(admin_level_path.`level_id`) AS level_id,
                GROUP_CONCAT(c2.`name` ORDER BY admin_level_path.level SEPARATOR \' > \') AS name,
                any_value(c1.`status`) AS status,any_value(c1.`module_id`) AS module_id,
                any_value(c1.`sort`) AS sort')
            ->with('module')
            ->orderBy('c1.sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::level.index',['res'=>$res]);
    }

    public function rebuild()
    {
        (new LevelPath)->rebuild();
        throw new ApiException(['code'=>0,'msg'=>'操作成功']);
    }

    public function tree()
    {
        $res['list'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
        $res['module'] = (new Module)->getByCache();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'树','href'=>'/admin/'.$this->currArr['key'].'/tree']
        ]);
        return $this->makeView('laravel-admin::level.tree',['res'=>$res]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
            $post['uuid'] = $this->manager->uuid;
            if($post['pid']){
                $parent = Level::where('id',$post['pid'])->first();
                if(!empty($parent) && $parent->status==2){
                    $post['status'] = $parent->status;
                }
            }
			$res['info'] = Level::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				(new LevelPath)->add($res['info']->id,$res['info']->pid);
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/level/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'添加失败','data'=>[]]);
			}
		}else{
			$res['info'] = Level::where('id',$request->query('id',0))->firstOrNew();
			return $this->makeView('laravel-admin::level.form',['res'=>$res]);
		}
	}

	public function edit(Request $request)
	{
		$res['info'] = Level::where('id',$request->query('id',0))->firstOrError();
		if($request->isMethod('post')) {
			$post = $request->all();
			$form_edit = $request->input('form_edit',0);
			if($res['info']->update($post)){
                if($post['status']==2){
                    $res['info']->closeChildStatus($res['info']->id);
                }
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url:'/admin/level/tree']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
            $res['module'] = (new Module)->getByCache();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
			return $this->makeView('laravel-admin::level.form',['res'=>$res]);
		}
	}

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Level::where('pid',$post)->get();
            if($data->isEmpty()){
                Level::destroy($post);
                LevelPath::whereIn('level_id',$post)->delete();
                throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'请先删除子分类']);
            }
        }
    }

    public function ajax(Request $request){
        $name = $request->query('name',false);
        $list = LevelPath::leftJoin('admin_level as c1','c1.id','=','admin_level_path.level_id')
            ->leftJoin('admin_level as c2','c2.id','=','admin_level_path.path_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->where('c1.status', 1)
            ->groupBy('level_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(admin_level_path.`level_id`) AS level_id,
                GROUP_CONCAT(c2.`name` ORDER BY admin_level_path.level SEPARATOR \' > \') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

}
