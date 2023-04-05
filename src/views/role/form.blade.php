
<div class="top-bar">
    <h5 class="nav-title">角色编辑</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/admin/role/edit?id={{$res['info']['id']}}" @else action="/admin/role/add" @endif class="save_form">
        @csrf
        <input type="hidden" name="form_edit" value="1">
        <div class="">
            <div class="form-group" >
                <label for="">模块</label>
                <select name="module_id" class="form-control" >
                    @foreach($res['module'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->module_id) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">描述</label>
                <input type="text" name="desc" class="form-control " value="{{$res['info']['desc']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div>
                <label for="">层级</label>
                <input type="hidden" id="level_id"  name="level_id" class="form-control " value="{{$res['info']['level_id']}}">
                <input type="text" id="level_name" onclick="tree_box(this)" readonly class="form-control tree_box_pre" value="{{$res['levelList'][$res['info']['level_id']]['name']??''}}">
                <div class="tree_box">
                    <div class="tree_p">
                        <div id="tree" ></div>
                    </div>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" >
                <label for="">数据权限</label>
                <select name="data_perm" class="form-control">
                    @foreach($dict['data_perm'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['data_perm']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" >
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['status']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']['sort']??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<style>

</style>
<script>
    var my_tree = new MyTree({
        root:0,
        list : @json($res['levelList']),
        select:{}
    })
    $(function () {
        function mount(){
            let treeData = my_tree.treeFormat(my_tree.op.list,[{{$res['info']['level_id']}}])
            $('#tree').jstree({
                "core": {
                    "themes":{
                        "dots": false,
                        "icons":false
                    },
                    "data": treeData
                },
                "plugins": ["themes"]
            }).on('select_node.jstree', function(el,_data) {
            }).on("changed.jstree", function(el,data) {
                my_tree.op.select = my_tree.getSelectObj(data)
                $('#level_id').val(my_tree.op.select[0].data.id)
                $('#level_name').val(my_tree.op.select[0].text)
                $('.tree_box').hide();
            })
        }
        mount()
    })
    function tree_box(_this) {
        $('.tree_box').toggle();
    }
</script>
