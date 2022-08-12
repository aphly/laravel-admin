<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\LaravelAdmin\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public $index_url = '/admin/news/index';

    public function index(Request $request)
    {
        $res['filter']['title'] = $title = $request->query('title', false);
        $res['filter']['string'] = http_build_query($request->query());
        $res['list'] = News::when($title,
                            function ($query, $title) {
                                return $query->where('title', 'like', '%' . $title . '%');
                            })
                        ->orderBy('id', 'desc')
                        ->Paginate(config('admin.perPage'))->withQueryString();
        return $this->makeView('laravel-admin::news.index', ['res' => $res]);
    }

    public function form(Request $request)
    {
        $res['info'] = News::where('id',$request->query('id',0))->firstOrNew();
        return $this->makeView('laravel-admin::news.form',['res'=>$res]);
    }

    public function save(Request $request){
        News::updateOrCreate(['id'=>$request->query('id',0)],$request->all());
        throw new ApiException(['code'=>0,'msg'=>'success','data'=>['redirect'=>$this->index_url]]);
    }

    public function del(Request $request)
    {
        $query = $request->query();
        $redirect = $query?$this->index_url.'?'.http_build_query($query):$this->index_url;
        $post = $request->input('delete');
        if(!empty($post)){
            News::whereIn('id',$post)->delete();
            throw new ApiException(['code'=>0,'msg'=>'操作成功','data'=>['redirect'=>$redirect]]);
        }
    }
}
