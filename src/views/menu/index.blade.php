
<div class="top-bar">
    <h5 class="nav-title">菜单管理
    </h5>
</div>
<style>
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/menu/index" class="select_form">
            <div class="search_box ">
                <input type="search" name="name" placeholder="菜单名称" value="{{$res['search']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get tree_div_btn" data-href="/admin/menu/tree">树形</a>
        </div>
    </div>

    <form method="post" @if($res['search']['string']) action="/admin/menu/del?{{$res['search']['string']}}" @else action="/admin/menu/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块id</li>
                    <li >名称 </li>
                    <li >类型 </li>
                    <li >路由</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li><span class="module_id badge">{{$v['module_id']}}</span></li>
                            <li>{{$v['name']}} </li>
                            <li>
                                @if($dict['menu_type'])
                                    @if($v->type==1)
                                        <span class="alert alert-primary my_alert">{{$dict['menu_type'][$v->type]}}</span>
                                    @elseif($v->type==2)
                                        <span class="alert alert-secondary my_alert">{{$dict['menu_type'][$v->type]}}</span>
                                    @elseif($v->type==3)
                                        <span class="alert alert-success my_alert">{{$dict['menu_type'][$v->type]}}</span>
                                    @endif
                                @endif
                            </li>
                            <li>
                                {{$v['route']}}
                            </li>
                            <li>
                                @if($dict['status'])
                                    @if($v->status==1)
                                        <span class="badge badge-success">{{$dict['status'][$v->status]}}</span>
                                    @else
                                        <span class="badge badge-secondary">{{$dict['status'][$v->status]}}</span>
                                    @endif
                                @endif
                            </li>
                            <li>
                                <a class="badge badge-info ajax_get" data-href="/admin/menu/edit?id={{$v['id']}}">编辑</a>
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
