<div class="top-bar">
    <h5 class="nav-title">用户管理 {{$res['info']['nickname']}}</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/user/{{$res['info']['uuid']}}/password" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">密码</label>
                <input type="text" name="credential" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>




