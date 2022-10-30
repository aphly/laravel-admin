
<div class="top-bar">
    <h5 class="nav-title">角色</h5>
</div>

<div class="imain">
    <div class="show_all0 max_width">
        <div class="min_width d-flex justify-content-between">
            <div class="show_all">
                <div class="show_title">角色列表</div>
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
                                    <option value="1">子角色</option>
                                    <option value="0">目录</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="">名称</label>
                                <input type="text" name="name" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group" id="status">
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
<style>
   .fast_form_btn a.ajax_get { line-height: 34px;padding: 0 15px;}
</style>
<script>
    var fast_form = '#fast_form';
    var list = @json($res['list']);
    var listById = @json($res['listById']);
    var data = toTree(selectData(list,false))
    var id = 0,pid = 0;
    var fast_save_url = '/admin/role';
    var fast_del_url = '/admin/role/del';
    var fast_del_url_return = '/admin/role/show';
    var _token = '{{csrf_token()}}';
    var hide_id = ['#status']

    $(function () {
        fast_show_btn(true)
        $('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            data,
            onNodeSelected: function(event, data) {
                id = pid = data.id
                fast_show_btn(true)
            },
            onNodeUnselected: function(event, data) {
                id = pid = 0
                fast_show_btn(true)
            },
        });
        $('#show_btn').on('click','span',function () {
            $(this).addClass('curr').siblings().removeClass('curr')
        })
        $('#is_leaf').change(function () {
            if($(this).val()==='1'){
                $('#status').show();
            }else{
                $('#status').hide();
            }
        })
    })

</script>
