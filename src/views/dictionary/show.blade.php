
<div class="top-bar">
    <h5 class="nav-title">字典</h5>
</div>

<div class="imain">
    <div class="show_all0 max_width">
        <div class="min_width d-flex justify-content-between">
            <div class="show_all">
                <div class="show_title">字典列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="show_op" >
                <div id="show_btn"></div>
                <div id="fast_form" style="display: none;">
                    <form method="post" >
                        @csrf
                        <input type="hidden" name="pid" class="form-control" value="0" >
                        <div class="">
                            <div class="form-group">
                                <label for="">类型</label>
                                <select name="is_leaf" id="is_leaf" class="form-control">
                                    <option value="1">字典</option>
                                    <option value="0">目录</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">名称</label>
                                <input type="text" name="name" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">值</label>
                                <input type="text" name="value" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">图标</label>
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
                                            <div class="attr5">操作</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary" onclick="fast_save()">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var fast_form = '#fast_form';
    var list = @json($res['list']);
    var listById = @json($res['listById']);
    var data = toTree(selectData(list,false))
    var id = 0;
    var fast_save_url = '/admin/dictionary/save';
    var fast_del_url = '/admin/dictionary/del';
    var fast_del_url_return = '/admin/dictionary/show';
    var _token = '{{csrf_token()}}';

    $(function () {
        fast_show_btn()
        $('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            onNodeSelected: function(event, data) {
                id = data.id
                fast_show_btn()
            },
            onNodeUnselected: function(event, data) {
                id = 0
                fast_show_btn()
            },
        });
        $('#show_btn').on('click','span',function () {
            $(this).addClass('curr').siblings().removeClass('curr')
        })
    })


</script>
