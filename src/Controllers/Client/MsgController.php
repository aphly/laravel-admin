<?php

namespace Aphly\LaravelAdmin\Controllers\Client;

use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Msg;

use Aphly\LaravelAdmin\Controllers\Controller;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    public $index_url = '/admin_client/msg/index';

    private $currArr = ['name'=>'消息','key'=>'msg'];

    public function index(Request $request)
    {
        $res['search']['viewed'] = $request->query('viewed', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Msg::when($res['search'],
                            function ($query, $search) {
                                if($search['viewed']!==''){
                                    $query->where('viewed', $search['viewed']);
                                }
                            })
                        ->with('msgDetail')->where('status',1)->where('to_uuid',Manager::_uuid())
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::client.msg.index', ['res' => $res]);
    }

    public function detail(Request $request)
    {
        $res['info'] = Msg::where('id',$request->query('id',0))->with('user')->with('msgDetail')->firstOrError();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'详情','href'=>'/admin_client/'.$this->currArr['key'].'/detail?id='.$res['info']->id]
        ]);
        if($res['info']->viewed==2){
            $res['info']->update(['viewed'=>1]);
        }
        return $this->makeView('laravel-admin::client.msg.detail',['res'=>$res]);
    }



}
