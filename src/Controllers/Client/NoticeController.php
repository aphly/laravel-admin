<?php

namespace Aphly\LaravelAdmin\Controllers\Client;

use Aphly\Laravel\Models\Breadcrumb;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Notice;

use Aphly\LaravelAdmin\Controllers\Controller;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public $index_url = '/admin_client/notice/index';

    private $currArr = ['name'=>'公告','key'=>'notice'];

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
                        ->where('status',1)->dataPerm(Manager::_uuid(),$this->roleLevelIds)
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::client.notice.index', ['res' => $res]);
    }


    public function detail(Request $request)
    {
        $res['info'] = Notice::where('id',$request->query('id',0))->firstOrError();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'],'href'=>$this->index_url],
            ['name'=>'详情','href'=>'/admin_cm/'.$this->currArr['key'].'/detail?id='.$res['info']->id]
        ]);
        return $this->makeView('laravel-admin::client.notice.detail',['res'=>$res]);
    }


}
