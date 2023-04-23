<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/module/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="模块名称" value="{{$res['search']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/admin/module/add">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/module/del?{{$res['search']['string']}}" @else action="/admin/module/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块名称</li>
                    <li >key</li>
                    <li >状态</li>
                    <li >排序</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)

                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{ $v['name'] }}</li>
                            <li>{{ $v['key'] }}</li>
                            <li>
                                @if($v['status'])
                                    <span class="badge badge-success">已安装</span>
                                @else
                                    <span class="badge badge-secondary">未安装</span>
                                @endif
                            </li>
                            <li>{{$v['sort']}}</li>
                            <li>
                                <a class="badge badge-info ajax_get" data-href="/admin/module/edit?id={{$v['id']}}">编辑</a>
                                @if($v['id']==1)
                                @else
                                    @if(class_exists($v['classname']))
                                        @if($v['status']==1)
                                            <a class="badge badge-primary ajax_post" data-href="/admin/module/install?id={{$v['id']}}&status=0">卸载</a>
                                        @else
                                            <a class="badge badge-primary ajax_post" data-href="/admin/module/install?id={{$v['id']}}&status=1">安装</a>
                                        @endif
                                    @endif
                                @endif
                            </li>
                        </ul>

                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['list']->links('laravel::admin.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>


