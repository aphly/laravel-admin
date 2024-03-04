<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
</style>
<div class="imain">

    <form method="post"  @if($res['search']['string']) action="/admin/module/del?{{$res['search']['string']}}" @else action="/admin/module/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块名称</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['unimport'])
                    @foreach($res['unimport'] as $v)
                    <ul class="table_tbody">
                        <li ></li>
                        <li >{{str_replace('Aphly\Laravel','',$v)}}</li>
                        <li ><span class="badge badge-warning">未导入</span></li>
                        <li >
                            <a class="badge badge-primary ajax_request" data-load="/admin/comm/module?id={{$res['info']->id}}" data-href="{{$res['info']->host}}/comm/module/import?class={{$v}}&comm_id={{$res['info']->id}}&sign={{$res['sign']}}">导入</a>
                        </li>
                    </ul>
                    @endforeach
                @endif
                @if($res['list'])
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li>{{ $v['id'] }}</li>
                            <li>{{ $v['name'] }}</li>
                            <li>
                                @if($v['status'])
                                    <span class="badge badge-success">已安装</span>
                                @else
                                    <span class="badge badge-secondary">未安装</span>
                                @endif
                            </li>
                            <li>
                                <a class="badge badge-info ajax_html d-none" data-href="/admin/module/edit?id={{$v['id']}}">编辑</a>
                                @if($v['id']!=1)
                                    @if($v['status']==1)
                                        <a class="badge badge-danger ajax_request" data-confirm="true" data-load="/admin/comm/module?id={{$res['info']->id}}" data-href="{{$res['info']->host}}/comm/module/uninstall?id={{$v['id']}}&comm_id={{$res['info']->id}}&sign={{$res['sign']}}">卸载</a>
                                    @else
                                        <a class="badge badge-primary ajax_request" data-load="/admin/comm/module?id={{$res['info']->id}}" data-href="{{$res['info']->host}}/comm/module/install?id={{$v['id']}}&comm_id={{$res['info']->id}}&sign={{$res['sign']}}">安装</a>
                                    @endif
                                @endif
                            </li>
                        </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                        </li>
                        <li>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </form>
</div>


