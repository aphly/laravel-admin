<div class="top-bar">
    <h5 class="nav-title">禁止访问</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/banned/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="ip" placeholder="ip" value="{{$res['search']['ip']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/admin/banned/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/banned/del?{{$res['search']['string']}}" @else action="/admin/banned/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >IP</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{ $v['ip'] }}</li>
                            <li>
                                @if($dict['status'])
                                    @if($v['status'])
                                        <span class="badge badge-success">{{$dict['status'][$v['status']]}}</span>
                                    @else
                                        <span class="badge badge-secondary">{{$dict['status'][$v['status']]}}</span>
                                    @endif
                                @endif
                            </li>
                            <li>
                                <a class="badge badge-info ajax_get" data-href="/admin/banned/form?id={{$v['id']}}">编辑</a>
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


