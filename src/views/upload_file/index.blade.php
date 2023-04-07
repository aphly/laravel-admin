<div class="top-bar">
    <h5 class="nav-title">文件管理</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 200px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 200px;}
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 200px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/upload_file/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="uuid" placeholder="uuid" value="{{$res['search']['uuid']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/upload_file/del?{{$res['search']['string']}}" @else action="/admin/upload_file/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >UUID</li>
                    <li >level_id</li>
                    <li >path</li>
                    <li >时间</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{ $v['uuid'] }}</li>
                            <li>
                                {{ $v['level_id'] }}
                            </li>
                            <li>
                                {{ $v['path'] }}
                            </li>
                            <li>
                                {{ $v['created_at'] }}
                            </li>
                            <li>
                                <a class="badge badge-info ajax_get" data-href="/admin/upload_file/edit?id={{$v['id']}}">编辑</a>
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


