
<div class="top-bar">
    <h5 class="nav-title">菜单管理
        @if($res['pid'])
            <span>- <a class="ajax_get" data-href="/admin/menu/index?pid={{$res['parent']['pid']}}">{{$res['parent']['name']}}</a></span>
        @endif


    </h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 500px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" @if($res['pid']) action="/admin/menu/index?pid={{$res['pid']}}" @else action="/admin/menu/index" @endif class="select_form">
            <div class="filter ">
                <input type="search" name="name" placeholder="菜单名称" value="{{$res['filter']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/admin/menu/show">浏览</a>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#fast_add" class="badge badge-info fast_add">新增</a>
        </div>
        <div class="d-none"><a data-href="/admin/menu/add?pid={{$res['pid']}}" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post" @if($res['filter']['string']) action="/admin/menu/del?{{$res['filter']['string']}}" @else action="/admin/menu/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >名称</li>
                    <li >链接地址</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{$v['name']}}</li>
                            <li>
                                {{$v['url']}}
                            </li>
                            <li>
                                @if($v['status'])
                                    <span class="badge badge-success">开启</span>
                                @else
                                    <span class="badge badge-secondary">关闭</span>
                                @endif
                            </li>
                            <li>
                                @if(!$v['is_leaf'])
                                    <a class="badge badge-primary ajax_get" data-href="/admin/menu/index?pid={{$v['id']}}">进入</a>
                                @endif
                                <a class="badge badge-info ajax_get" data-href="/admin/menu/{{$v['id']}}/edit?pid={{$res['pid']}}">编辑</a>
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

<div class="modal fade ajax_modal" id="fast_add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">新增菜单</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/menu/add" data-action="/admin/menu/add" id="fast_form" class="save_form">
                    @csrf
                    <div class="">
                        <div class="form-group" style="position: relative;">
                            <label for="">父级菜单</label>
                            <input type="text" id="p_name" class="form-control" value="" onclick="mytoggle(this)" readonly>
                            <div id="tree_p" style="position: absolute;display: none;width: 100%;background: #fff;box-shadow: 0 1px 4px rgb(24 38 16 / 10%);">
                                <div id="tree" class="treeview"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">类型</label>
                            <select name="is_leaf" id="is_leaf" class="form-control">
                                <option value="1">菜单</option>
                                <option value="0">目录</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">名称</label>
                            <input type="text" name="name" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group" id="url">
                            <label for="">链接地址</label>
                            <input type="text" name="url" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">图标 class</label>
                            <input type="text" name="icon" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">状态</label>
                            <select name="status" class="form-control">
                                <option value="1" >开启</option>
                                <option value="0" >关闭</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">排序</label>
                            <input type="text" name="sort" class="form-control " value="0">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var json_data = @json($res['menu']);
    var select_ids = false;
    var data = toTree(selectData(json_data,select_ids))
    $(function () {
        var bTree =$('#tree').treeview({
            levels: 2,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            //multiSelect:true,
            onNodeSelected: function(event, data) {
                let obj = $('#fast_form');
                obj.attr('action',obj.data('action')+'?pid='+data.id)
                $('#p_name').val(data.text)
                $('#tree_p').hide();
            },
            onNodeUnselected: function(event, data) {
                let obj = $('#fast_form');
                obj.attr('action',obj.data('action'))
                $('#p_name').val('')
                $('#tree_p').hide();
            },
        });
    })
    function mytoggle(_this) {
        $(_this).next().toggle();
    }
</script>
