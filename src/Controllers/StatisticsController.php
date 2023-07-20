<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Breadcrumb;

use Aphly\Laravel\Models\Statistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public $index_url = '/admin/statistics/index';

    private $currArr = ['name'=>'统计','key'=>'statistics'];


    public function index(Request $request)
    {
        $res['search']['ip'] = $request->query('ip', '');
        $res['search']['string'] = http_build_query($request->query());
        $res['list'] = Statistics::when($res['search'],
                            function ($query, $search) {
                                if($search['ip']!==''){
                                    $query->where('ip', $search['ip']);
                                }
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url]
        ]);
        return $this->makeView('laravel-admin::statistics.index', ['res' => $res]);
    }

    public function detail(Request $request)
    {
        $res['info'] = Statistics::where('id',$request->query('id',0))->firstOrNew();
        $res['breadcrumb'] = Breadcrumb::render([
            ['name'=>$this->currArr['name'].'管理','href'=>$this->index_url],
            ['name'=>'详情','href'=>'/admin/'.$this->currArr['key'].'/detail?id='.$res['info']->id]
        ]);
        return $this->makeView('laravel-admin::statistics.detail',['res'=>$res]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            Statistics::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }


}
