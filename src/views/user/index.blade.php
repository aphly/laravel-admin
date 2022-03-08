<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 200px;}
    .del_form .table_scroll .table_header li:nth-child(6),.del_form .table_scroll .table_tbody li:nth-child(6){flex-basis:300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/user/index" class="select_form">
        <div class="filter ">
            <input type="search" name="identifier" placeholder="邮箱" value="{{$res['filter']['identifier']}}">
            <select name="status" >
                <option value ="1" @if($res['filter']['status']==1) selected @endif>正常</option>
                <option value ="2" @if($res['filter']['status']==2) selected @endif>冻结</option>
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a href="/register" target="_blank" class="badge badge-info  add">新增</a></div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/admin/user/del?{{$res['filter']['string']}}" @else action="/admin/user/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >UUID</li>
                    <li >昵称</li>
                    <li >头像</li>
                    <li >用户组</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['data']->total())
                    @foreach($res['data'] as $v)
                    <ul class="table_tbody">
                        <li>
                            <input type="checkbox" class="delete_box" name="delete[]" value="{{$v['uuid']}}">
                            <a target="_blank" href="/autologin/{{ Illuminate\Support\Facades\Crypt::encryptString($v->token)}}">{{$v['uuid']}}</a>
                        </li>
                        <li > <span style="color:#111;">{{$v['nickname']}}</span></li>
                        <li>
                            @if($v['avatar'])
                                <img class="lazy user_avatar" src="{{Storage::url($v['avatar'])}}" />
                            @else
                            <img class="lazy user_avatar" @if($v['gender']==1) src="{{url('vendor/laravel/img/man.png')}}" @else src="{{url('vendor/laravel/img/woman.png')}}" @endif >
                            @endif
                        </li>
                        <li>{{$res['role'][$v['role_id']]['name']}}</li>
                        <li>{{Aphly\Laravel\Models\User::getStatus($v['status'])}}</li>
                        <li>
                            <a class="badge badge-success ajax_get" data-href="/admin/user/{{$v['uuid']}}/role">用户组</a>
                            <a class="badge badge-info ajax_get" data-href="/admin/user/{{$v['uuid']}}/edit">编辑</a>
                            <a class="badge badge-info ajax_get" data-href="/admin/user/{{$v['uuid']}}/password">修改密码</a>
                            <a class="badge badge-info ajax_get" data-href="/admin/user/{{$v['uuid']}}/avatar">头像</a>
                        </li>
                    </ul>
                    <div style="margin-left: 40px;margin-bottom: 10px;">
                        @foreach($v->userAuth as $vv)
                            <div style="margin-right: 40px;">
                                <span class="badge badge-warning">{{$vv->identity_type}}</span>
                                <span class="">{{$vv->identifier}}</span>
                            </div>
                        @endforeach
                    </div>
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
