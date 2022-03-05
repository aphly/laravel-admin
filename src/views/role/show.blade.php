<script src='{{ URL::asset('vendor/laravel/js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<div class="top-bar">
    <h5 class="nav-title">角色</h5>
</div>
<div class="imain">
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">角色列表</div>
                <div id="tree" class="treeview"></div>
            </div>

        </div>
    </div>
</div>

<script>
    var role = @json($res['role_show']);
    function roleData(data) {
        let new_array = []
        data.forEach((item,index) => {
            new_array.push({id:item.id,text:item.name,pid:item.pid})
            delete item.nodes;
        });
        return new_array;
    }
    var data = toTree(roleData(role))
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
