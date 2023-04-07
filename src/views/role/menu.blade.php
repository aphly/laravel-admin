<div class="top-bar">
    <h5 class="nav-title">角色菜单</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu" >
                <div class="role_title">菜单列表</div>
                <div id="tree" class="treeview"></div>
                <form method="post" action="/admin/role/menu?id={{$res['info']['id']}}" class="save_form">
                    @csrf
                    <div class="select_ids d-flex flex-wrap" id="select_ids"></div>
                    <div class="d-flex flex-row-reverse">
                        <button style="margin-right: 20px;" class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<style>

</style>
<script>

    function makeInput(arr) {
        let html = '';
        for(let i in arr){
            html += `<input type="hidden" name="menu_id[]" value="${arr[i]}">`
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
                    "keep_selected_style" : false,
                    "three_state": false
                },
                "plugins": ["checkbox","themes"]
            }).on('select_node.jstree', function(el,_data) {
            }).on("changed.jstree", function(el,data) {
                let ids = my_tree.getSelectIds(data)
                //let undetermined = data.instance.get_undetermined();
                makeInput(ids)
            })
        }
        mount()
    })
</script>
