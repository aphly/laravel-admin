<script src='{{ URL::asset('js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<div class="top-bar">
    <h5 class="nav-title">角色权限</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <div class="d-flex ">
        <div>
            <div id="tree" class="treeview"></div>
        </div>
        <div>
            <form method="post" action="/admin/role/{{$res['info']['id']}}/permission" class="save_form">
                @csrf
                <div class="cl qx">
                    @foreach($res['permission'] as $v)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="inlineCheckbox{{$v['id']}}" type="checkbox" name="permission_id[]" @if(in_array($v['id'],$res['role_permission'])) checked @endif value="{{$v['id']}}">
                            <label class="form-check-label" for="inlineCheckbox{{$v['id']}}">{{$v['name']}}</label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-primary" type="submit">保存</button>
            </form>
        </div>
    </div>

</div>

<script>
    var permission = @json($res['permission']);
    function toMyTree(data,select_ids=0) {
        let new_array = []
        data.forEach((item,index) => {
            if(select_ids){
                let selected=false,disabled=false;
                if(in_array(item.id,select_ids)){
                    selected=true;
                }
                if(!item.is_leaf){
                    disabled=true;
                }
                new_array.push({id:item.id,text:item.name,pid:item.pid,state:{selected,disabled}})
            }else{
                new_array.push({id:item.id,text:item.name,pid:item.pid})
            }
            delete item.nodes;
        });
        return new_array;
    }
    var data = toTree(toMyTree(permission))
    console.log(data)
    $(function () {
        $('#tree').treeview({
            levels: 2,
            collapseIcon:'uni app-jian',
            expandIcon:'uni app-jia',
            data,
            multiSelect:true,
            onNodeSelected: function(event, data) {
                $('#pid').val(data.id)
            },
            onNodeUnselected: function(event, data) {
                if($('#pid').val()==data.id){
                    $('#pid').val(0)
                }
            },
        });
    })

</script>
