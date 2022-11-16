
<div class="top-bar">
    <h5 class="nav-title">菜单</h5>
</div>

<div class="imain">
    <div class="show_all0 max_width">
        <div class="min_width d-flex justify-content-between">
            <div class="show_all">
                <div class="show_title">菜单列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="show_op" >
                <div id="show_btn"></div>
                <div id="fast_form" style="display: none;">
                    <form method="post" >
                        @csrf
                        <input type="hidden" name="pid" class="form-control" value="0" >
                        <div class="">
                            <div class="form-group module_div" style="display: none;">
                                <label for="">模块</label>
                                <select name="module_id" class="form-control">
                                    @foreach($res['module'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">类型</label>
                                <select name="is_leaf" id="is_leaf" class="form-control">
                                    <option value="1">子菜单</option>
                                    <option value="0">目录</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">名称</label>
                                <input type="text" name="name" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group" style="position: relative;">
{{--                                <label for="">父级</label>--}}
{{--                                <input type="text" class="form-control p_name" value="" readonly>--}}
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
                                    @foreach($dict['status'] as $key=>$val)
                                        <option value="{{$key}}" >{{$val}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">排序</label>
                                <input type="number" name="sort" class="form-control " value="0">
                                <div class="invalid-feedback"></div>
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
    var treeGlobal = {
        fast_form : '#fast_form',
        list : @json($res['list']),
        listById:@json($res['listById']),
        data:[],
        id:0,
        pid:0,
        fast_save_url:'/admin/menu',
        fast_del_url:'/admin/menu/del',
        fast_del_url_return:'/admin/menu/show',
        _token:'{{csrf_token()}}',
        hide_id:[]
    }
    treeGlobal.data = toTree(selectData(treeGlobal.list,false));

    function mount(){
        fast_show_btn()
        $('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            data:treeGlobal.data,
            onNodeSelected: function(event, data) {
                treeGlobal.id = treeGlobal.pid = data.id
                fast_show_btn()
            },
            onNodeUnselected: function(event, data) {
                treeGlobal.id = treeGlobal.pid = 0
                fast_show_btn()
            },
        });
        $('#show_btn').on('click','span',function () {
            $(this).addClass('curr').siblings().removeClass('curr')
        })
    }

    $(function () {
        mount()
    })

</script>
