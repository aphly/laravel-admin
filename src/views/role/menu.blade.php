<script src='{{ URL::asset('js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<div class="top-bar">
    <h5 class="nav-title">角色菜单</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <form method="post" action="/admin/role/{{$res['info']['id']}}/menu" class="save_form">
        @csrf
        <div class="cl qx">
            <div id="menu_ids"></div>
            <div id="tree" class="treeview"></div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<script>
    var menu = @json($res['menu']);
    var select_ids = @json($res['role_menu']);
    console.log(select_ids);
    function in_array(search,array){
        for(var i in array){
            if(array[i]==search){
                return true;
            }
        }
        return false;
    }
    function toMyTree(data,select_ids=0) {
        let new_array = []
        data.forEach((item,index) => {
            if(select_ids){
                if(in_array(item.id,select_ids)){
                    console.log('a'+item.id);
                    new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected:true}})
                }else{
                    console.log(item.id);
                    new_array.push({id:item.id,text:item.name,pid:item.pid})
                }
            }else{

                new_array.push({id:item.id,text:item.name,pid:item.pid})
            }
            delete item.nodes;
        });
        return new_array;
    }
    var menu_ids = {}
    function makeMenuInput() {
        let ids=[]
        for(var i in menu_ids){
            if(menu_ids[i]){
                ids.push(i)
            }
        }
        $("#menu_ids").html('');
        let html = '';
        ids.forEach(i=>{
            html += `<input type="hidden" name="menu_id[]" value="${i}">`
        })
        $("#menu_ids").append(html);
    }
    var data = toTree(toMyTree(menu,select_ids))
    $(function () {
        $('#tree').treeview({
            levels: 2,
            collapseIcon:'uni app-jian',
            expandIcon:'uni app-jia',
            multiSelect:true,
            data,
            onNodeSelected: function(event, data) {
                menu_ids[data.id]=true;
                makeMenuInput()
            },
            onNodeUnselected: function(event, data) {
                menu_ids[data.id]=false;
                makeMenuInput()
            },
        });
    })

</script>
