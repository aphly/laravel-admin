<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">接口列表</div>
                <div id="tree" class="treeview"></div>
                <form method="post" action="/admin/role/api?id={{$res['info']['id']}}" class="save_form">
                    @csrf
                    <div class=" select_ids" id="select_ids"></div>
                    <div class="d-flex flex-row-reverse">
                        <button style="margin-right: 20px;" class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>

    function makeInput(arr1) {
        let html = '';
        for(let i in arr1){
            html += `<input type="hidden" name="api_id[]" value="${arr1[i]}">`
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
