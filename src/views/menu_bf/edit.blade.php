<script src='{{ URL::asset('js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<div class="top-bar">
    <h5 class="nav-title">菜单编辑</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/menu/{{$res['info']['id']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">菜单名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">链接地址</label>
                <input type="text" name="url" class="form-control " value="{{$res['info']['url']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">父级菜单</label>
                <input type="hidden" name="pid" id="pid" class="form-control " value="{{$res['info']['pid']}}">
                <div class="invalid-feedback"></div>
                <div id="tree" class="treeview"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

<script>
    var menu = @json($res['menu']);
    var data = toTree(toMyTree(menu,{{$res['info']['id']}}))
    $(function () {
        $('#tree').treeview({
            levels: 2,
            collapseIcon:'uni app-jian',
            expandIcon:'uni app-jia',
            data,
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
