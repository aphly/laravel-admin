<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 300px;}
    .manager_role{background: #2878a7; color: #fff; border-radius: 4px; padding: 0 2px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/manager/index" class="select_form">
        <div class="filter ">
            <input type="search" name="username" placeholder="用户名" value="{{$res['filter']['username']}}">
            <select name="status" >
                @foreach($dict['user_status'] as $key=>$val)
                    <option value="{{$key}}" @if($res['filter']['status']==$key) selected @endif>{{$val}}</option>
                @endforeach
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a data-href="/admin/manager/add" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/admin/manager/del?{{$res['filter']['string']}}" @else action="/admin/manager/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >UUID</li>
                    <li >用户名</li>
                    <li >头像</li>
                    <li >角色</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['uuid']}}">{{$v['uuid']}}</li>
                        <li>{{$v['username']}}</li>
                        <li>
                            <img class="lazy user_avatar" @if($v['gender']==1) src="{{url('vendor/laravel/img/man.png')}}" @else src="{{url('vendor/laravel/img/woman.png')}}" @endif >
                        </li>
                        <li>
                            @foreach($v->role as $vv)
                                <span class="manager_role">{{$vv->name}}</span>
                            @endforeach
                        </li>
                        <li>
                            @if($dict['user_status'])
                                @if($v['status'])
                                    <span class="badge badge-success">{{$dict['status'][$v['status']]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['status'][$v['status']]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-success ajax_get" data-href="/admin/manager/{{$v['uuid']}}/role">角色</a>
                            <a class="badge badge-info ajax_get" data-href="/admin/manager/{{$v['uuid']}}/edit">编辑</a>
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

