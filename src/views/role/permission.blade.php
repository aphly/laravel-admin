
<div class="top-bar">
    <h5 class="nav-title">权限</h5>
</div>
<div class="imain">
    <div class="userinfo">
        角色名称：{{$res['info']['name']}}
    </div>
    <form method="post" action="/admin/role/{{$res['info']['id']}}/permission" class="userform">
        @csrf
        <div class="cl qx">
            @foreach($res['permission'] as $v)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="permission_id[]" @if(in_array($v['id'],$res['rolepermission'])) checked @endif value="{{$v['id']}}">
                    <label class="form-check-label" for="inlineCheckbox1">{{$v['name']}}</label>
                </div>
            @endforeach
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

