<div class="top-bar">
    <h5 class="nav-title">权限</h5>
</div>
<div class="imain">
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">权限列表</div>
                <div id="tree" class="treeview"></div>
            </div>

        </div>
    </div>
</div>

<script>
    var permission = @json($res['permission_show']);
    var data = toTree(selectData(permission,false))
    $(function () {
        var bTree =$('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data
        });
    })
</script>
