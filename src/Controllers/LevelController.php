<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Level;
use Aphly\Laravel\Models\LevelPath;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public $index_url='/admin/level/index';

    public function index(Request $request)
    {
        $res['search']['name'] = $name = $request->query('name',false);
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = LevelPath::leftJoin('admin_level as c1','c1.id','=','admin_level_path.level_id')
            ->leftJoin('admin_level as c2','c2.id','=','admin_level_path.path_id')
            ->when($name,
                function($query,$name) {
                    return $query->where('c1.name', 'like', '%'.$name.'%');
                })
            ->groupBy('level_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(admin_level_path.`level_id`) AS level_id,
                GROUP_CONCAT(c2.`name` ORDER BY admin_level_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->orderBy('c1.sort','desc')
            ->Paginate(config('admin.perPage'))->withQueryString();
        //$res['fast_save'] = Level::where('status',1)->orderBy('sort', 'desc')->get()->toArray();
        return $this->makeView('laravel-admin::level.index',['res'=>$res]);
    }

    public function form(Request $request)
    {
        $res['info'] = Level::where('id',$request->query('id',0))->firstOrNew();
        if(!empty($res['info']) && $res['info']->pid){
            $res['parent_info'] = Level::where('id',$res['info']->pid)->first();
        }
        return $this->makeView('laravel-admin::level.form',['res'=>$res]);
    }

    public function show()
    {
        $data = Level::orderBy('sort', 'desc')->get();
        $res['list'] = $data->toArray();
        $res['listById'] = $data->keyBy('id')->toArray();
        return $this->makeView('laravel-admin::level.show',['res'=>$res]);
    }

    public function save(Request $request){
        $id = $request->query('id',0);
        $form_edit = $request->input('form_edit',0);
        if($form_edit && $id){
            Level::updateOrCreate(['id'=>$id],$request->all());
        }else{
            $level = Level::updateOrCreate(['id'=>$id,'pid'=>$request->input('pid',0)],$request->all());
            (new LevelPath)->add($level->id,$level->pid);
            $this->index_url = '/common_admin/level/show';
        }
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

	public function add(Request $request)
	{
		if($request->isMethod('post')) {
			$post = $request->all();
			$res['info'] = Level::create($post);
			$form_edit = $request->input('form_edit',0);
			if($res['info']->id){
				(new LevelPath)->add($res['info']->id,$res['info']->pid);
				throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/admin/level/show']]);
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
				throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$form_edit?$this->index_url($post):'/common_admin/level/show']]);
			}else{
				throw new ApiException(['code'=>1,'msg'=>'修改失败','data'=>[]]);
			}
		}else{
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
                GROUP_CONCAT(c2.`name` ORDER BY admin_level_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name,
                any_value(c1.`status`) AS status,
                any_value(c1.`sort`) AS sort')
            ->get()->toArray();
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['list'=>$list]]);
    }

}
