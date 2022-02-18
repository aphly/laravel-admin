<div class="top-bar">
    <h5 class="nav-title">权限编辑</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/permission/{{$res['info']['id']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">路由名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">路由地址</label>
                <input type="text" name="controller" class="form-control " value="{{$res['info']['controller']}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

