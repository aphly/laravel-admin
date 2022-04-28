<div class="top-bar">
    <h5 class="nav-title">字典管理
        @if($res['pid'])
            <span>- <a class="ajax_get" data-href="/admin/dictionary/index?pid={{$res['parent']['pid']}}">{{$res['parent']['name']}}</a></span>
        @endif
    </h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 500px;}
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 200px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" @if($res['pid']) action="/admin/dictionary/index?pid={{$res['pid']}}" @else action="/admin/dictionary/index" @endif class="select_form">
            <div class="filter ">
                <input type="search" name="name" placeholder="字典名称" value="{{$res['filter']['name']}}">
                <button class="" type="submit">搜索</button>
            </div>
        </form>
        <div class="">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#fast_add" class="badge badge-info fast_add">新增</a></div>
        <div class="d-none"><a data-href="/admin/dictionary/add?pid={{$res['pid']}}" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post" @if($res['filter']['string']) action="/admin/dictionary/del?{{$res['filter']['string']}}" @else action="/admin/dictionary/del" @endif  class="del_form">
        @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >名称</li>
                    <li >值</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                        <ul class="table_tbody">
                            <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                            <li>{{$v['name']}}</li>
                            <li>
                                {{$v['value']}}
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
                                    <a class="badge badge-primary ajax_get" data-href="/admin/dictionary/index?pid={{$v['id']}}">进入</a>
                                @endif
                                <a class="badge badge-info ajax_get" data-href="/admin/dictionary/{{$v['id']}}/edit?pid={{$res['pid']}}">编辑</a>
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
                <h5 class="modal-title" id="staticBackdropLabel">新增字典</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post"  action="/admin/dictionary/add" data-action="/admin/dictionary/add" id="fast_form" class="save_form">
                    @csrf
                    <div class="">
                        <div class="form-group" style="position: relative;">
                            <label for="exampleInputEmail1">父级菜单</label>
                            <input type="text" id="p_name" class="form-control" value="" onclick="mytoggle(this)" readonly>
                            <div id="tree_p" style="position: absolute;display: none;width: 100%;background: #fff;box-shadow: 0 1px 4px rgb(24 38 16 / 10%);">
                                <div id="tree" class="treeview"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">类型</label>
                            <select name="is_leaf" id="is_leaf" class="form-control">
                                <option value="1">字典</option>
                                <option value="0">目录</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">名称</label>
                            <input type="text" name="name" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">值</label>
                            <input type="text" name="value" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">图标</label>
                            <input type="text" name="icon" class="form-control " value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">状态</label>
                            <select name="status" class="form-control">
                                <option value="1" >开启</option>
                                <option value="0" >关闭</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">排序</label>
                            <input type="number" name="sort" class="form-control " value="0">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <div onclick="attr_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> 添加属性</div>
                            <div class="add_div">
                                <ul class="add_div_ul">
                                    <li class="d-flex">
                                        <div class="attr1">名称</div>
                                        <div class="attr2">值</div>
                                        <div class="attr3">图标</div>
                                        <div class="attr4">排序</div>
                                        <div class="attr0">组</div>
                                        <div class="attr8">扩1</div>
                                        <div class="attr9">扩2</div>
                                        <div class="attr5">操作</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var json_data = @json($res['dictionary']);
    var select_ids = false;
    var data = toTree(selectData(json_data,select_ids))
    $(function () {
        var bTree =$('#tree').treeview({
            levels: 1,
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
