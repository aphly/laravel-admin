<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/level/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="name" value="{{$res['search']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_request tree_div_btn" data-href="/admin/level/rebuild">重建层级</a>
            <a class="badge badge-primary ajax_html tree_div_btn" data-href="/admin/level/tree">树形</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/level/del?{{$res['search']['string']}}" @else action="/admin/level/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块</li>
                    <li >name</li>
                    <li >sort</li>
                    <li >状态</li>
                    <li>操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li><span class="module_id badge">{{$v->module->name??''}}</span></li>
                        <li>{{$v['name']}}</li>
                        <li>
                            {{$v['sort']}}
                        </li>
                        <li>
                            @if($dict['status'])
                                @if($v->status==1)
                                    <span class="badge badge-success">{{$dict['status'][$v->status]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$v->status!=null?$dict['status'][$v->status]:''}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/admin/level/edit?id={{$v['id']}}">编辑</a>
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


