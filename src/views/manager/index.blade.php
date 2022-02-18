<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/manager/index" class="select_form">
        <div class="filter ">
            <input type="search" name="username" placeholder="用户名" value="{{$res['filter']['username']}}">
            <select name="status" >
                <option value ="1" @if($res['filter']['status']==1) selected @endif>正常</option>
                <option value ="2" @if($res['filter']['status']==2) selected @endif>冻结</option>
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a data-href="/admin/manager/add" class="badge badge-info get add">新增</a></div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/admin/manager/del?{{$res['filter']['string']}}" @else action="/admin/manager/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >用户名</li>
                    <li >头像</li>
                    <li >手机号</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['data']->total())
                    @foreach($res['data'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{$v['username']}}</li>
                        <li><img src="{{$v['avatar']}}" class="avatar"></li>
                        <li>{{$v['phone']}}</li>
                        <li>{{$v['status']}}</li>
                        <li>
                            <a class="badge badge-success get" data-href="/admin/manager/{{$v['id']}}/role">角色</a>
                            <a class="badge badge-info get" data-href="/admin/manager/{{$v['id']}}/edit">编辑</a>
                            <a class="badge badge-info get" data-href="/admin/manager/{{$v['id']}}/avatar">头像</a>
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

