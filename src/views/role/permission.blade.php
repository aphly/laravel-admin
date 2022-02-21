
<div class="top-bar">
    <h5 class="nav-title">角色权限</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <form method="post" action="/admin/role/{{$res['info']['id']}}/permission" class="save_form">
        @csrf
        <div class="cl qx">
            @foreach($res['permission'] as $v)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="inlineCheckbox{{$v['id']}}" type="checkbox" name="permission_id[]" @if(in_array($v['id'],$res['role_permission'])) checked @endif value="{{$v['id']}}">
                    <label class="form-check-label" for="inlineCheckbox{{$v['id']}}">{{$v['name']}}</label>
                </div>
            @endforeach
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

