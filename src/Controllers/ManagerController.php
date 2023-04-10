<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\LevelPath;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\ManagerRole;
use Aphly\Laravel\Models\Role;
use Aphly\LaravelAdmin\Requests\ManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public $index_url='/admin/manager/index';

    public function index(Request $request)
    {
        $res['title']='';
        $res['search']['username'] = $username = $request->query('username',false);
        $res['search']['status'] = $status = $request->query('status',false);
        $res['search']['string'] = http_build_query($request->query());
        $manager = Auth::guard('manager')->user();
        $level_ids = (new Role)->hasLevelIds(session('role_id'));
        $res['list'] = Manager::when($username,
                            function($query,$username) {
                                return $query->where('username', 'like', '%'.$username.'%');
                            })
                        ->when($status,
                            function($query,$status) {
                                return $query->where('status', '=', $status);
                            })
                        ->dataPerm($manager->uuid,$level_ids)
                        ->with('role')
                        ->orderBy('uuid', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::manager.index',['res'=>$res]);
    }

    public function add(ManagerRequest $request)
    {
        if($request->isMethod('post')){
            $regRole = Role::where('id',Role::reg_id)->firstOrError();
            $input = $request->all();
            $input['uuid'] = $input['token'] = Helper::uuid();
            $input['token_expire'] = time();
            $input['level_id'] = $regRole->level_id;
            $input['password'] = Hash::make($input['password']);
            $res['info'] = Manager::create($input);
            if($res['info']->uuid){
                ManagerRole::create(['uuid'=>$res['info']->uuid,'role_id'=>$regRole->id]);
                throw new ApiException(['code'=>0,'msg'=>'添加成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'添加失败']);
            }
        }else{
            $res['info'] = Manager::where('uuid',$request->query('uuid',0))->firstOrNew();
            return $this->makeView('laravel-admin::manager.form',['res'=>$res]);
        }
    }

    public function edit(ManagerRequest $request)
    {
        $res['info'] = Manager::where('uuid',$request->query('uuid',0))->firstOrNew();
        if($request->isMethod('post')) {
            $input = $request->all();
            if(!empty($input['password'])){
                $input['password'] = Hash::make($input['password']);
            }else{
                unset($input['password']);
            }
            if($res['info']->update($input)){
                throw new ApiException(['code'=>0,'msg'=>'修改成功','data'=>['redirect'=>$this->index_url]]);
            }else{
                throw new ApiException(['code'=>1,'msg'=>'修改失败']);
            }
        }else{
            return $this->makeView('laravel-admin::manager.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Manager::destroy($post);
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function role(Request $request)
    {
        $res['info'] = Manager::find($request->query('uuid',0));
        if($request->isMethod('post')) {
            if($res['info']){
                $res['info']->role()->sync($request->input('role_id'));
                $mainRole = Role::where('id',$request->input('main_role_id',0))->first();
                if(!empty($mainRole)){
                    $res['info']->level_id= $mainRole->level_id;
                    $res['info']->save();
                }
            }
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['manager_role'] = ManagerRole::where('uuid',$res['info']->uuid)->with('role')->get()->toArray();
            $res['select_ids'] = array_column($res['manager_role'], 'role_id');
            $res['roleList'] = Role::where('status',1)->orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            $level_ids = array_column($res['roleList'], 'level_id');
            $res['role_level'] = LevelPath::leftJoin('admin_level','admin_level.id','=','admin_level_path.path_id')->whereIn('admin_level_path.level_id',$level_ids)
                ->groupBy('admin_level_path.level_id')->selectRaw('any_value(admin_level_path.`level_id`) AS level_id,GROUP_CONCAT(admin_level.`name` ORDER BY admin_level_path.level SEPARATOR  \'>\') as name')
                ->get()->keyBy('level_id')->toArray();
            return $this->makeView('laravel-admin::manager.role',['res'=>$res]);
        }
    }


}
