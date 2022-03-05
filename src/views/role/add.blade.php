
<div class="top-bar">
    <h5 class="nav-title">角色新增</h5>
</div>
<div class="imain">
    <form method="post" @if($res['pid']) action="/admin/role/add?pid={{$res['pid']}}" @else action="/admin/role/add" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control">
                    <option value="1">角色</option>
                    <option value="0">目录</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
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
