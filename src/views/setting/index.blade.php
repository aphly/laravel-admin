<div class="top-bar">
    <h5 class="nav-title">参数管理</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/setting/index" class="select_form">
        <div class="filter ">
            <input type="search" name="name" placeholder="参数名称" value="{{$res['filter']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/admin/setting/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/admin/setting/del?{{$res['filter']['string']}}" @else action="/admin/setting/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >[模块id] ID</li>
                    <li >参数Code</li>
                    <li >Key</li>
                    <li ></li>
                    <li ></li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}"><span class="huis">[{{$v['module_id']}}]</span> {{$v['id']}}</li>
                        <li>{{ $v['name'] }}</li>
                        <li>{{$v['key']}}</li>
                        <li>
                        </li>
                        <li></li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/admin/setting/form?id={{$v['id']}}">编辑</a>
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


