<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/user/{{$res['info']['uuid']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">昵称</label>
                <input type="text" name="nickname" pattern="[A-Za-z0-9]{6,30}" class="form-control " value="{{$res['info']['nickname']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">性别</label>
                <select name="gender"  class="form-control">
                    <option value="1" @if($res['info']['gender']==1) selected @endif>男</option>
                    <option value="2" @if($res['info']['gender']==1) @else selected @endif >女</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">密码</label>
                <input type="text" name="credential" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            @foreach($res['info']->userAuth as $v)
                <div>
                    {{$v->identity_type}} {{$v->identifier}} {{$v->verified}} {{date('Y-m-d H:i:s',$v->last_login)}} {{$v->last_ip}}
                </div>
            @endforeach
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>




