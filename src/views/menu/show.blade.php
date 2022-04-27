
<div class="top-bar">
    <h5 class="nav-title">菜单</h5>
</div>
<div class="imain">
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">菜单列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div style="width: 45%;">
                <div id="show_btn"></div>
                <div>
                    <form method="post" action="/admin/menu/save" data-action="/admin/menu/save" id="fast_form">
                        @csrf
                        <div class="">
                            <div class="form-group" style="position: relative;">
                                <label for="exampleInputEmail1">父级菜单</label>
                                <input type="text" id="p_name" class="form-control" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">类型</label>
                                <select name="is_leaf" id="is_leaf" class="form-control">
                                    <option value="1">菜单</option>
                                    <option value="0">目录</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">名称</label>
                                <input type="text" name="name" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group" id="url">
                                <label for="exampleInputEmail1">链接地址</label>
                                <input type="text" name="url" class="form-control " value="">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">图标 class</label>
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
                                <input type="text" name="sort" class="form-control " value="0">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-primary" onclick="save('#fast_form')">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var list = @json($res['list']);
    var listById = @json($res['listById']);
    var data = toTree(selectData(list,false))
    //console.log(selectData(list,false))
    var selectId = 0;
    function show_btn() {
        if(selectId){
            if(listById[selectId].is_leaf){
                $('#show_btn').html('编辑 删除')
            }else{
                $('#show_btn').html('新增 编辑 删除')
            }
        }else{
            $('#show_btn').html('新增')
        }
    }

    $(function () {
        show_btn()
        $('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            onNodeSelected: function(event, data) {
                selectId = data.id
                show_btn()
            },
            onNodeUnselected: function(event, data) {
                selectId = 0
                show_btn()
            },
        });
    })
    function save(id) {
        let url = '/admin/menu/save?id={{request()->query('id',0)}}';
        $.ajax({
            url,
            dataType:'json',
            type:'post',
            data:$(id).serialize(),
            success:function (res) {
                if(!res.code) {
                    $("#iload").load(res.data.redirect);
                    alert_msg(res)
                }else if(res.code===11000){
                    for(var item in res.data){
                        let str = ''
                        res.data[item].forEach((elem, index)=>{
                            str = str+elem+'<br>'
                        })
                        let obj = $(id+' input[name="'+item+'"]');
                        obj.removeClass('is-valid').addClass('is-invalid');
                        obj.next('.invalid-feedback').html(str);
                    }
                }else{
                    alert_msg(res)
                }
            }
        })
    }
</script>
