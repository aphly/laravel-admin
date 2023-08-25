<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Msg;

use Aphly\Laravel\Models\MsgDetail;
use Aphly\Laravel\Models\UploadFile;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    public $index_url = '/admin/msg/index';

    private $currArr = ['name'=>'消息','key'=>'msg'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['uuid'] = $request->query('uuid', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Msg::when($res['search'],
                            function ($query, $search) {
                                if($search['uuid']!==''){
                                    $query->where('to_uuid', $search['uuid']);
                                }
                            })
                        ->with('user')->with('msgDetail')
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::msg.index', ['res' => $res]);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $input['content'] = (new Editor)->add($request->input('content'));
            $msgDetail = MsgDetail::create($input);
            if(!empty($msgDetail)){
                $username_arr = explode(';',$input['username']);
                $username_arr = array_filter(array_map('trim',$username_arr));
                $managers = Manager::whereIn('username',$username_arr)->get();
                $data = [];
                $time = time();
                foreach ($managers as $val){
                    $data[] = [
                        'uuid' => $this->manager->uuid,
                        'to_uuid' => $val->uuid,
                        'msg_detail_id' => $msgDetail->id,
                        'viewed'=>$input['viewed'],
                        'status'=>$input['status'],
                        'created_at'=>$time,
                        'updated_at'=>$time,
                    ];
                }
                Msg::insert($data);
            }
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['info'] = Msg::where('id',$request->query('id',0))->with('user')->with('msgDetail')->firstOrNew();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
            $res['imgSize'] = $this->imgSize;
            return $this->makeView('laravel-admin::msg.form',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        $res['info'] = Msg::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')){
            $input = $request->all();
            $res['info_detail'] = MsgDetail::where('id',$res['info']->msg_detail_id)->firstOrError();
            $input['content'] = (new Editor)->edit($res['info_detail']->content,$request->input('content'));
            $res['info_detail']->update($input);
            $res['info']->update($input);
            throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
            $res['imgSize'] = $this->imgSize;
            return $this->makeView('laravel-admin::msg.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Msg::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            Msg::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function uploadImg(Request $request){
        $file = $request->file('msgImg');
        if($file){
            $UploadFile = (new UploadFile($this->imgSize));
            try{
                $image = $UploadFile->upload($file,'public/editor_temp/msg');
            }catch(ApiException $e){
                $err = ["errno"=>$e->code,"message"=>$e->msg];
                return $err;
            }
            $res = ["errno"=>0,"data"=>["url"=>$UploadFile->getPath($image,'local')]];
        }else{
            $res = ["errno"=>1,"data"=>[]];
        }
        return $res;
    }
}
