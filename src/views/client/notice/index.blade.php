<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 280px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 180px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin_client/notice/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="title" placeholder="标题" value="{{$res['search']['title']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
    </div>

    <form method="post"  @if($res['search']['string']) action="/admin/notice/del?{{$res['search']['string']}}" @else action="/admin/notice/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >标题</li>
                    <li >日期</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li class="wenzi">{{$v['title']}}</li>
                        <li class="wenzi">{{$v['created_at']}}</li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/admin_client/notice/detail?id={{$v['id']}}">查看</a>
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


