
<div class="top-bar">
    <h5 class="nav-title">授权</h5>
</div>
<div class="imain">
    <div class="userinfo">
        用户名：{{$res['info']['username']}}
    </div>
    <form method="post" action="/admin/user/{{$res['info']['id']}}/role" class="userform">
        @csrf
        <div class="cl qx">
            @foreach($res['role'] as $v)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="role_id[]" @if(in_array($v['id'],$res['userrole'])) checked @endif value="{{$v['id']}}">
                    <label class="form-check-label" for="inlineCheckbox1">{{$v['name']}}</label>
                </div>
            @endforeach
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>


