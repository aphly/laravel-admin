<div class="top-bar">
    <h5 class="nav-title">配置管理 (需要更新缓存)</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/config/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="配置名称" value="{{$res['search']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/admin/config/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/config/del?{{$res['search']['string']}}" @else action="/admin/config/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块id</li>
                    <li >name</li>
                    <li >type</li>
                    <li >key</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li><span class="module_id badge">{{$v['module_id']}}</span></li>
                        <li>{{ $v['name'] }}</li>
                        <li>{{$v['type']}}</li>
                        <li>{{$v['key']}}</li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/admin/config/form?id={{$v['id']}}">编辑</a>
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

