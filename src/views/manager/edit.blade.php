<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/manager/{{$res['info']['id']}}/edit" class="userform">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" name="username" required class="form-control @error('username') is-invalid @enderror" value="{{$res['info']['username']}}">
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">昵称</label>
                <input type="text" name="nickname" pattern="[A-Za-z0-9]{6,30}" class="form-control @error('nickname') is-invalid @enderror" value="{{$res['info']['nickname']}}">
                @error('nickname')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">手机号</label>
                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{$res['info']['phone']}}">
                @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">邮箱</label>
                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$res['info']['email']}}">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">密码</label>
                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" value="">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>






