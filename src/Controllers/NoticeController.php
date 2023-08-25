<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Libs\Editor;
use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Level;
use Aphly\Laravel\Models\Notice;

use Aphly\Laravel\Models\UploadFile;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public $index_url = '/admin/notice/index';

    private $currArr = ['name'=>'公告','key'=>'notice'];

    public $imgSize = 1;

    public function index(Request $request)
    {
        $res['search']['title'] = $request->query('title', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Notice::when($res['search'],
                            function ($query, $search) {
                                if($search['title']!==''){
                                    $query->where('title', 'like', '%' . $search['title'] . '%');
                                }
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::notice.index', ['res' => $res]);
    }

    public function add(Request $request)
    {
        if($request->isMethod('post')){
            $input = $request->all();
            $input['uuid'] = $this->manager->uuid;
            $input['content'] =  (new Editor)->add($request->input('content'));
            Notice::create($input);
            throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
        }else{
            $res['info'] = Notice::where('id',$request->query('id',0))->firstOrNew();
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'新增','href'=>'/admin/'.$this->currArr['key'].'/add']
            ]);
            $res['levelList'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            $res['imgSize'] = $this->imgSize;
            return $this->makeView('laravel-admin::notice.form',['res'=>$res]);
        }
    }

    public function edit(Request $request)
    {
        $res['info'] = Notice::where('id',$request->query('id',0))->firstOrError();
        if($request->isMethod('post')){
            $input = $request->all();
            $input['content'] = (new Editor)->edit($res['info']->content,$request->input('content'));
            $res['info']->update($input);
            throw new ApiException(['code' => 0, 'msg' => 'success', 'data' => ['redirect' => $this->index_url]]);
        }else{
            $res['breadcrumb'] = Breadcrumb::render([
                ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
                ['name'=>'编辑','href'=>'/admin/'.$this->currArr['key'].'/edit?id='.$res['info']->id]
            ]);
            $res['imgSize'] = $this->imgSize;
            $res['levelList'] = Level::orderBy('sort', 'desc')->get()->keyBy('id')->toArray();
            return $this->makeView('laravel-admin::notice.form',['res'=>$res]);
        }
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            $data = Notice::whereIn('id',$post)->get();
            foreach($data as $val){
                (new Editor)->del($val->content);
            }
            Notice::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }

    public function uploadImg(Request $request){
        $file = $request->file('noticeImg');
        if($file){
            $UploadFile = (new UploadFile($this->imgSize));
            try{
                $image = $UploadFile->upload($file,'public/editor_temp/notice');
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
