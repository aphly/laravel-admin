<script src='{{ URL::asset('vendor/laravel-admin/js/bootstrap-treeview.js') }}' type='text/javascript'></script>
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
                    <div class=" select_ids" id="select_ids"></div>
                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    var menu = @json($res['menu']);
    var select_ids = @json($res['select_ids']);
    function roleData(data,select_ids=0) {
        let new_array = []
        data.forEach((item,index) => {
            if(select_ids){
                let selected=in_array(item.id,select_ids)?true:false;
                new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected}})
            }else{
                new_array.push({id:item.id,text:item.name,pid:item.pid})
            }
            delete item.nodes;
        });
        return new_array;
    }
    var data = toTree(roleData(menu,select_ids))
    $(function () {
        var bTree =$('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            multiSelect:true,
            onNodeSelected: function(event, data) {
                makeInput();
            },
            onNodeUnselected: function(event, data) {
                makeInput();
            },
        });
        var makeInput = function () {
            let arr = bTree.treeview('getSelected');
            let html = '';
            for(let i in arr){
                html += `<div data-nodeid="${arr[i].nodeId}"><input type="hidden" name="menu_id[]" value="${arr[i].id}">${arr[i].text} <span class="uni app-guanbi"></span></div> `
            }
            $("#select_ids").html(html);
        }
        makeInput();
        $('#select_ids').on('click','div', function () {
            bTree.treeview('unselectNode', [ $(this).data('nodeid'), { silent: false } ]);
        });
    })
</script>
