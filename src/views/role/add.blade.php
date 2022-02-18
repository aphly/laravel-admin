
<div class="top-bar">
    <h5 class="nav-title">角色新增</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/role/add" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">角色名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>
