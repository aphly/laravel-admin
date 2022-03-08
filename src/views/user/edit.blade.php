<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <form method="post" action="/admin/user/{{$res['info']['uuid']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">昵称</label>
                <input type="text" name="nickname"  class="form-control " value="{{$res['info']['nickname']}}">
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
                <label for="exampleInputEmail1">状态</label>
                <select name="status"  class="form-control">
                    <option value="1" @if($res['info']['status']==1) selected @endif>正常</option>
                    <option value="2" @if($res['info']['status']==1) @else selected @endif >冻结</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="" style="margin-bottom: 20px;">
                <ul>
                @foreach($res['info']->userAuth as $v)
                    <li>
                        <span class="badge badge-warning">{{$v->identity_type}}</span>
                        <span>{{$v->identifier}}</span>
                        @if($v->identity_type=='email')
                            <span class="badge badge-warning">邮件是否已校验</span> <input name="verified" type="checkbox" value="1" @if($v->verified) checked @endif >
                        @endif
                        <span class="badge badge-warning">最后登录时间</span> {{$v->last_login?date('Y-m-d H:i:s',$v->last_login):'-'}}
                        <span class="badge badge-warning">最后登录ip</span> {{$v->last_ip}}
                    </li>
                @endforeach
                </ul>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>




