
<div class="top-bar">
    <h5 class="nav-title">用户新增</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/manager/add" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">用户名</label>
                <input type="text" name="username" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">昵称</label>
                <input type="text" name="nickname" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">手机号</label>
                <input type="text" name="phone" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">邮箱</label>
                <input type="text" name="email" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">性别</label>
                <input type="text" name="gender" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">性别</label>
                <select name="gender"  class="form-control">
                    @foreach($dict['user_gender'] as $key=>$val)
                        <option value="{{$key}}" >{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['user_status'] as $key=>$val)
                        <option value="{{$key}}" >{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">密码</label>
                <input type="text" name="password" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>


