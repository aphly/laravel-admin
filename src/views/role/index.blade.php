<div class="top-bar">
    <h5 class="nav-title">角色管理</h5>
</div>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/role/index" class="select_form">
            <div class="filter ">
                <input type="search" name="name" placeholder="角色名" value="{{$res['filter']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class=""><a data-href="/admin/role/add" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/admin/role/del?{{$res['filter']['string']}}" @else action="/admin/role/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >角色名称</li>
                    <li >操作</li>
                </ul>
                @if($res['data']->total())
                    @foreach($res['data'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{$v['name']}}</li>
                            <li>
                                <a class="badge badge-success ajax_get" data-href="/admin/role/{{$v['id']}}/permission">授权</a>
                                <a class="badge badge-success ajax_get" data-href="/admin/role/{{$v['id']}}/menu">菜单</a>
                                <a class="badge badge-info ajax_get" data-href="/admin/role/{{$v['id']}}/edit">编辑</a>
                            </li>
                        </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['data']->links('laravel-admin::common.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>
