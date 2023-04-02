<div class="top-bar">
    <h5 class="nav-title">角色菜单</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">菜单列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="role">
                <div class="role_title">已选中</div>
                <form method="post" action="/admin/role/{{$res['info']['id']}}/menu" class="save_form">
                    @csrf
                    <div class="select_ids d-flex flex-wrap" id="select_ids"></div>
                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>

</div>
<style>

</style>
<script>

    function makeInput() {
        let arr = mountTree.treeview('getSelected');
        let html = '';
        for(let i in arr){
            html += `<div data-nodeid="${arr[i].nodeId}"><input type="hidden" name="menu_id[]" value="${arr[i].id}">${arr[i].text} <span class="uni app-guanbi"></span></div> `
        }
        $("#select_ids").html(html);
    }

    var my_tree = new MyTree({
        root:0,
        tree_form : '#tree_form',
        list : @json($res['list']),
        select_ids : @json($res['select_ids']),
        select:{},
        type:'add',
        tree_save_url:'/admin/permission',
        tree_del_url:'/admin/permission/del',
        tree_del_url_return:'/admin/permission/tree',
        _token:'{{csrf_token()}}'
    })
    $(function () {
        function mount(){
            my_tree.tree_btn()
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
                my_tree.op.select = my_tree.getSelectObj(data)
            })
        }
        mount()
        $('#tree_form').on('click','.submit',function () {
            my_tree.tree_save()
        })
    })
</script>
