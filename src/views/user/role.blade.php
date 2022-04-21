<div class="top-bar">
    <h5 class="nav-title">用户组</h5>
</div>
<div class="imain">
    <div class="userinfo">
        用户名：{{$res['info']['nickname']}}
    </div>
    <div class="role_permission max_width">
        <div class="min_width d-flex">
            <div class="permission_menu">
                <div class="role_title">用户组列表</div>
                <div id="tree" class="treeview"></div>
            </div>
            <div class="role">
                <div class="role_title">已选中</div>
                <form method="post" action="/admin/user/{{$res['info']['uuid']}}/role" class="save_form">
                    @csrf
                    <div class=" select_ids" id="select_ids"></div>
                    <button class="btn btn-primary" type="submit">保存</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var role = @json($res['role']);
    var select_ids = @json($res['select_ids']);
    function roleData(data,select_ids=0) {
        let new_array = []
        data.forEach((item,index) => {
            let selectable = item.is_leaf?true:false;
            if(select_ids){
                let selected=in_array(item.id,select_ids)?true:false;
                new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected},selectable})
            }else{
                new_array.push({id:item.id,text:item.name,pid:item.pid})
            }
            delete item.nodes;
        });
        return new_array;
    }
    var data = toTree(roleData(role,select_ids))
    $(function () {
        var bTree =$('#tree').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            multiSelect:false,
            onNodeSelected: function(event, data) {
                makeInput();
            },
        });
        var makeInput = function () {
            let arr = bTree.treeview('getSelected');
            let html = '';
            for(let i in arr){
                html += `<div data-nodeid="${arr[i].nodeId}"><input type="hidden" name="role_id" value="${arr[i].id}">${arr[i].text} </div> `
            }
            $("#select_ids").html(html);
        }
        makeInput();

    })
</script>
