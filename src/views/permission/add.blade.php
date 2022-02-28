<div class="top-bar">
    <h5 class="nav-title">权限新增
        @if($res['pid'])
            <span>- {{$res['parent']['name']}}</span>
        @endif
    </h5>
</div>
<div class="imain">
    <form method="post"  @if($res['pid']) action="/admin/permission/add?pid={{$res['pid']}}" @else action="/admin/permission/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control">
                    <option value="1">权限</option>
                    <option value="0">目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="controller">
                <label for="exampleInputEmail1">控制器</label>
                <input type="text" name="controller" class="form-control " value="" placeholder="Aphly\LaravelAdmin\Controllers\IndexController@index">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group" id="status">
                <label for="exampleInputEmail1">状态</label>
                <select name="status" class="form-control">
                    <option value="1" >开启</option>
                    <option value="0" >关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">排序</label>
                <input type="text" name="sort" class="form-control " value="0">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
<script>
    $('#is_leaf').change(function () {
        if($(this).val()==='1'){
            $('#controller').show();
            $('#status').show();
        }else{
            $('#controller').hide();
            $('#status').hide();
        }
    })
</script>
