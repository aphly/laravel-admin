<div class="top-bar">
    <h5 class="nav-title">字典管理
        @if($res['pid'])
            <span>- <a class="ajax_get" data-href="/admin/dictionary/index?pid={{$res['parent']['pid']}}">{{$res['parent']['name']}}</a></span>
        @endif
    </h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 500px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" @if($res['pid']) action="/admin/dictionary/index?pid={{$res['pid']}}" @else action="/admin/dictionary/index" @endif class="select_form">
            <div class="filter ">
                <input type="search" name="name" placeholder="字典名称" value="{{$res['filter']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class="">
{{--            <a data-href="/admin/dictionary/add_fast" class="badge badge-info ajax_get add">快速新增</a>--}}
            <a data-href="/admin/dictionary/add?pid={{$res['pid']}}" class="badge badge-info ajax_get add">新增</a>
        </div>
    </div>

    <form method="post" @if($res['filter']['string']) action="/admin/dictionary/del?{{$res['filter']['string']}}" @else action="/admin/dictionary/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >名称</li>
                    <li >链接地址</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{$v['name']}}</li>
                            <li>
                                {{$v['url']}}
                            </li>
                            <li>
                                @if($v['status'])
                                    <span class="badge badge-success">开启</span>
                                @else
                                    <span class="badge badge-secondary">关闭</span>
                                @endif
                            </li>
                            <li>
                                @if(!$v['is_leaf'])
                                    <a class="badge badge-primary ajax_get" data-href="/admin/dictionary/index?pid={{$v['id']}}">进入</a>
                                @endif
                                <a class="badge badge-info ajax_get" data-href="/admin/dictionary/{{$v['id']}}/edit?pid={{$res['pid']}}">编辑</a>
                                <a class="badge badge-info ajax_get" data-href="/admin/dictionary/{{$v['id']}}/show">浏览</a>
                            </li>
                        </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['list']->links('laravel-admin::common.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>

