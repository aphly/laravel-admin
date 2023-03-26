
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
            </div>
            <div class="role">
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
    function makeInput() {
        let arr = mountTree.treeview('getSelected');
        let html = '';
        for(let i in arr){
            html += `<div data-nodeid="${arr[i].nodeId}"><input type="hidden" name="role_id[]" value="${arr[i].id}">${arr[i].text} <span class="uni app-guanbi"></span></div> `
        }
        $("#select_ids").html(html);
    }

    var treeGlobal = {
        role : @json($res['role']),
        select_ids : @json($res['select_ids']),
    }
    treeGlobal.data = toTree(roleData(treeGlobal.role,treeGlobal.select_ids))
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

    function mount(){
        makeInput();
        $('#select_ids').on('click','div', function () {
            mountTree.treeview('unselectNode', [ $(this).data('nodeid'), { silent: false } ]);
        });
    }

    $(function () {
        mount()
    })
</script>
