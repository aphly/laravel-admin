<div class="top-bar">
    <h5 class="nav-title">角色权限</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">权限列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="role">
                <div class="role_title">已选中</div>
                <form method="post" action="/admin/role/{{$res['info']['id']}}/permission" class="save_form">
                    @csrf
                    <div class=" select_ids" id="select_ids"></div>
                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    var treeGlobal = {
        permission : @json($res['permission']),
        select_ids : @json($res['select_ids'])
    }
    treeGlobal.data = toTree(treeData(treeGlobal.permission,treeGlobal.select_ids));

    function makeInput() {
        let arr = mountTree.treeview('getSelected');
        let html = '';
        for(let i in arr){
            html += `<div data-nodeid="${arr[i].nodeId}"><input type="hidden" name="permission_id[]" value="${arr[i].id}">${arr[i].text} <span class="uni app-guanbi"></span></div> `
        }
        $("#select_ids").html(html);
    }

    var mountTree =$('#tree').treeview({
        levels: 3,
        collapseIcon:'uni app-arrow-right-copy',
        expandIcon:'uni app-arrow-right',
        data:treeGlobal.data,
        multiSelect:true,
        onNodeSelected: function(event, data) {
            makeInput();
        },
        onNodeUnselected: function(event, data) {
            makeInput();
        },
    });

    function mount() {
        makeInput();
        $('#select_ids').on('click','div', function () {
            mountTree.treeview('unselectNode', [ $(this).data('nodeid'), { silent: false } ]);
        });
    }

    $(function () {
        mount()
    })
</script>
