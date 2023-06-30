<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin_client/msg/index" class="select_form">
        <div class="search_box ">
            <select name="viewed" >
                <option value="0" >全部</option>
                @foreach($dict['yes_no'] as $key=>$val)
                    <option value="{{$key}}" @if($res['search']['viewed']==$key) selected @endif>{{$val}}</option>
                @endforeach
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin_client/msg/del?{{$res['search']['string']}}" @else action="/admin_client/msg/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >标题</li>
                    <li >已读</li>
                    <li >日期</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody @if($v['viewed']==1) viewed @endif">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li class="wenzi">{{$v->msgDetail->title}}</li>
                        <li>
                            @if($dict['yes_no'])
                                @if($v['yes_no']==1)
                                    {{$dict['yes_no'][$v['viewed']]}}
                                @else
                                    {{$dict['yes_no'][$v['viewed']]}}
                                @endif
                            @endif
                        </li>
                        <li>
                            {{$v->created_at}}
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/admin_client/msg/detail?id={{$v['id']}}">查看</a>
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


