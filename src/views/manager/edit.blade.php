<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/manager/{{$res['info']['uuid']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">UUID : {{$res['info']['uuid']}}</label>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">用户名</label>
                <input type="text" name="username" required class="form-control" readonly value="{{$res['info']['username']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">昵称</label>
                <input type="text" name="nickname" pattern="[A-Za-z0-9]{6,30}" class="form-control " value="{{$res['info']['nickname']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">手机号</label>
                <input type="text" name="phone" class="form-control " value="{{$res['info']['phone']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">邮箱</label>
                <input type="text" name="email" class="form-control " value="{{$res['info']['email']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">性别</label>
                <select name="gender"  class="form-control">
                    @foreach($dict['user_gender'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['gender']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">密码</label>
                <input type="text" name="password" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['user_status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['info']['status']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>




