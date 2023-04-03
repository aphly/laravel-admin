
<div class="top-bar">
    <h5 class="nav-title">角色</h5>
</div>
<div class="imain">
    <div class="userinfo">
        用户名：{{$res['info']->username}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">角色列表</div>
                <div id="tree" class="treeview"></div>
                <div class="role_title">已选中</div>
                <form method="post" action="/admin/manager/role?uuid={{$res['info']->uuid}}" class="save_form">
                    @csrf
                    <div class=" select_ids" id="select_ids"></div>
                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>

    function makeInput(arr1) {
        let html = '';
        for(let i in arr1){
            html += `<input type="hidden" name="role_id[]" value="${arr1[i]}">`
        }
        $("#select_ids").html(html);
    }
    var my_tree = new MyTree({
        root:0,
        list : @json($res['list']),
        select_ids : @json($res['select_ids'])
    })
    $(function () {
        function mount(){
            let treeData = my_tree.treeFormat(my_tree.op.list,my_tree.op.select_ids)
            $('#tree').jstree({
                "core": {
                    "themes":{
                        "dots": false,
                        "icons":false
                    },
                    "data": treeData
                },
                "checkbox" : {
                    "keep_selected_style" : false
                },
                "plugins": ["checkbox","themes"]
            }).on('select_node.jstree', function(el,_data) {
            }).on("changed.jstree", function(el,data) {
                let ids = my_tree.getSelectIds(data)
                let undetermined = data.instance.get_undetermined();
                makeInput(ids,undetermined)
            })
        }
        mount()
    })
</script>
