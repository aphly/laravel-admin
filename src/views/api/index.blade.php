<div class="top-bar">
    <h5 class="nav-title">接口管理
    </h5>
</div>
<style>
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/admin/api/index" class="select_form">
            <div class="search_box ">
                <input type="search" name="name" placeholder="权限名" value="{{$res['search']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get tree_div_btn" data-href="/admin/api/tree">树形</a>
        </div>
    </div>

    <form method="post" @if($res['search']['string']) action="/admin/api/del?{{$res['search']['string']}}" @else action="/admin/api/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >模块</li>
                    <li >名称</li>
                    <li >类型</li>
                    <li >路由</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li><span class="module_id badge">{{$v->module->name}}</span></li>
                            <li>{{$v['name']}}</li>
                            <li>
                                @if($v['type']==2)
                                    <span class="alert alert-secondary my_alert">权限</span>
                                @else
                                    <span class="alert alert-primary my_alert">目录</span>
                                @endif
                            </li>
                            <li>
                                {{$v['route']}}
                            </li>
                            <li>
                                @if($dict['status'])
                                    @if($v['status']==1)
                                        <span class="badge badge-success my_badge">{{$dict['status'][$v['status']]}}</span>
                                    @else
                                        <span class="badge badge-secondary my_badge">{{$dict['status'][$v['status']]}}</span>
                                    @endif
                                @endif
                            </li>
                            <li>
                                <a class="badge badge-info ajax_get" data-href="/admin/api/edit?id={{$v['id']}}">编辑</a>
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

{{--<div class="modal fade ajax_modal" id="fast_add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="staticBackdropLabel">新增权限</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <form method="post" action="/admin/api/add" data-action="/admin/api/add" id="fast_form" class="save_form">--}}
{{--                    @csrf--}}
{{--                    <div class="">--}}
{{--                        <div class="form-group" style="position: relative;">--}}
{{--                            <label for="">父级菜单</label>--}}
{{--                            <input type="text" id="p_name" class="form-control" value="" onclick="mytoggle(this)" readonly>--}}
{{--                            <div id="tree_p" style="position: absolute;display: none;width: 100%;background: #fff;box-shadow: 0 1px 4px rgb(24 38 16 / 10%);">--}}
{{--                                <div id="tree" class="treeview"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">类型</label>--}}
{{--                            <select name="is_leaf" id="is_leaf" class="form-control">--}}
{{--                                <option value="1">权限</option>--}}
{{--                                <option value="0">目录</option>--}}
{{--                            </select>--}}
{{--                            <div class="invalid-feedback"></div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">名称</label>--}}
{{--                            <input type="text" name="name" class="form-control " value="">--}}
{{--                            <div class="invalid-feedback"></div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group" id="controller">--}}
{{--                            <label for="">控制器</label>--}}
{{--                            <input type="text" name="controller" class="form-control " value="" placeholder="Aphly\LaravelAdmin\Controllers\IndexController@index">--}}
{{--                            <div class="invalid-feedback"></div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group" id="status">--}}
{{--                            <label for="">状态</label>--}}
{{--                            <select name="status" class="form-control">--}}
{{--                                @foreach($dict['status'] as $key=>$val)--}}
{{--                                    <option value="{{$key}}" >{{$val}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            <div class="invalid-feedback"></div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="">排序</label>--}}
{{--                            <input type="text" name="sort" class="form-control " value="0">--}}
{{--                            <div class="invalid-feedback"></div>--}}
{{--                        </div>--}}
{{--                        <button class="btn btn-primary" type="submit">保存</button>--}}
{{--                    </div>--}}
{{--                </form>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script>--}}
{{--    var json_data = @json($res['permission']);--}}
{{--    var select_ids = false;--}}
{{--    var data = toTree(selectData(json_data,select_ids))--}}
{{--    $(function () {--}}
{{--        var bTree =$('#tree').treeview({--}}
{{--            levels: 2,--}}
{{--            collapseIcon:'uni app-arrow-right-copy',--}}
{{--            expandIcon:'uni app-arrow-right',--}}
{{--            selectedBackColor:'#f3faff',--}}
{{--            selectedColor:'#212529',--}}
{{--            data,--}}
{{--            //multiSelect:true,--}}
{{--            onNodeSelected: function(event, data) {--}}
{{--                let obj = $('#fast_form');--}}
{{--                obj.attr('action',obj.data('action')+'?pid='+data.id)--}}
{{--                $('#p_name').val(data.text)--}}
{{--                $('#tree_p').hide();--}}
{{--            },--}}
{{--            onNodeUnselected: function(event, data) {--}}
{{--                let obj = $('#fast_form');--}}
{{--                obj.attr('action',obj.data('action'))--}}
{{--                $('#p_name').val('')--}}
{{--                $('#tree_p').hide();--}}
{{--            },--}}
{{--        });--}}
{{--    })--}}
{{--    function mytoggle(_this) {--}}
{{--        $(_this).next().toggle();--}}
{{--    }--}}
{{--</script>--}}
